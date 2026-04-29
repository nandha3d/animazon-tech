param(
    [switch]$Full,
    [switch]$Build,
    [switch]$ClearCache,
    [string]$Ssh,
    [string[]]$File
)

$ErrorActionPreference = "Stop"

# ─── CONFIG ───────────────────────────────────────────
$SSH_HOST    = "217.21.74.44"
$SSH_PORT    = 65002
$SSH_USER    = "u362580417"
$SSH_PASS    = $env:ANIMAZON_SSH_PASS
if (-not $SSH_PASS) {
    Write-Host "[ERROR] Set the ANIMAZON_SSH_PASS environment variable before running this script." -ForegroundColor Red
    exit 1
}
$REMOTE_PATH = "domains/animazon.in/public_html"
$LOCAL_PATH  = "d:\PROJECTS\WEBSITES\animazon-tech"
$PLINK       = "$LOCAL_PATH\deploy-tools\plink.exe"
$PSCP        = "$LOCAL_PATH\deploy-tools\pscp.exe"

# Directories and patterns to NEVER upload
$EXCLUDE_DIRS = @(
    "node_modules", ".git", ".gemini", ".qodo", "tests", "deploy",
    "deploy-tools", "storage/logs", "storage/framework/sessions",
    "storage/framework/views", "storage/framework/cache",
    "bootstrap/cache", "react_landing_page", "portfolio-showcase", "scratch"
)
$EXCLUDE_PATTERNS = @(
    "*.zip", "*.sql", "*.log", ".env", ".env.backup", ".env.example",
    "setup_deploy.ps1", "deploy.ps1", "deploy.bat", "build_deployment.ps1",
    "_create_deploy_zip.ps1", "*.py", "last_error.txt", "tmp_err.log",
    "migrate_error.log", "migrate_error.txt", "migrate_output.txt"
)

# ─── HELPERS ──────────────────────────────────────────
function Test-Excluded($filePath) {
    $normalized = $filePath.Replace("\", "/")
    foreach ($dir in $EXCLUDE_DIRS) {
        if ($normalized -like "$dir/*" -or $normalized -eq $dir) { return $true }
    }
    $leaf = Split-Path $filePath -Leaf
    foreach ($pat in $EXCLUDE_PATTERNS) {
        if ($leaf -like $pat) { return $true }
    }
    return $false
}

function Invoke-Remote($cmd) {
    & $PLINK -P $SSH_PORT -pw $SSH_PASS "$SSH_USER@$SSH_HOST" $cmd 2>&1
}

function Upload-File($localFile, $remoteFile) {
    & $PSCP -P $SSH_PORT -pw $SSH_PASS -q $localFile "${SSH_USER}@${SSH_HOST}:$remoteFile" 2>&1
}

# ─── PRE-FLIGHT ───────────────────────────────────────
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "     ANIMAZON ONE-CLICK DEPLOY"          -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

if (-not (Test-Path $PLINK) -or -not (Test-Path $PSCP)) {
    Write-Host "[ERROR] Deploy tools missing! Re-download plink.exe and pscp.exe to deploy-tools\" -ForegroundColor Red
    exit 1
}

# Test connection
Write-Host "Testing server connection..." -ForegroundColor DarkGray
$testResult = Invoke-Remote "echo OK"
if ($testResult.Trim() -ne "OK") {
    Write-Host "[ERROR] Cannot connect to server. Check credentials." -ForegroundColor Red
    exit 1
}
Write-Host "[OK] Server connected." -ForegroundColor Green

# ─── MODE: Run SSH command ────────────────────────────
if ($Ssh) {
    Write-Host "`nRunning: $Ssh" -ForegroundColor Yellow
    Invoke-Remote "cd $REMOTE_PATH && $Ssh"
    exit 0
}

# ─── MODE: Clear cache only ──────────────────────────
if ($ClearCache -and -not $Full -and -not $File -and -not $Build) {
    Write-Host "`nClearing Laravel caches..." -ForegroundColor Yellow
    Invoke-Remote "cd $REMOTE_PATH && php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:clear 2>&1"
    Write-Host "[OK] Caches cleared!" -ForegroundColor Green
    exit 0
}

# ─── BUILD FRONTEND ──────────────────────────────────
if ($Build) {
    Write-Host "`n[BUILD] Running npm run build..." -ForegroundColor Yellow
    Push-Location $LOCAL_PATH
    npm run build
    Pop-Location
    Write-Host "[OK] Frontend build complete." -ForegroundColor Green
}

# ─── DETECT CHANGED FILES ────────────────────────────
$filesToDeploy = @()

if ($File) {
    $filesToDeploy = $File
    Write-Host "`nDeploying specified file(s):" -ForegroundColor Yellow
}
elseif ($Full) {
    Write-Host "`n[FULL] Scanning all project files..." -ForegroundColor Yellow
    $filesToDeploy = Get-ChildItem -Path $LOCAL_PATH -Recurse -File |
        ForEach-Object { $_.FullName.Substring($LOCAL_PATH.Length + 1).Replace("\", "/") } |
        Where-Object { -not (Test-Excluded $_) }
}
else {
    Write-Host "`nDetecting changed files via git..." -ForegroundColor Yellow
    Push-Location $LOCAL_PATH

    # Uncommitted changes (modified + staged + untracked)
    $dirty = @(git status --porcelain 2>$null | ForEach-Object {
        $line = $_.Trim()
        if ($line.Length -gt 2) { $line.Substring(2).Trim().Trim('"') }
    })

    # Last commit changes
    $committed = @(git diff --name-only "HEAD~1..HEAD" 2>$null)

    Pop-Location

    $combined = @($dirty) + @($committed) | Where-Object { $_ -and $_.Trim() }
    $filesToDeploy = $combined |
        Sort-Object -Unique |
        Where-Object { -not (Test-Excluded $_) } |
        Where-Object { Test-Path (Join-Path $LOCAL_PATH $_) }
}

$filesToDeploy = @($filesToDeploy)

if ($filesToDeploy.Count -eq 0) {
    Write-Host "`n[OK] No changed files found. Nothing to deploy!" -ForegroundColor Green
    Write-Host "Tips:" -ForegroundColor DarkGray
    Write-Host "  .\deploy.ps1 -Full           # Deploy ALL files" -ForegroundColor DarkGray
    Write-Host "  .\deploy.ps1 -File 'path'    # Deploy specific file" -ForegroundColor DarkGray
    Write-Host "  .\deploy.ps1 -ClearCache     # Clear server caches" -ForegroundColor DarkGray
    Write-Host "  .\deploy.ps1 -Ssh 'command'  # Run command on server" -ForegroundColor DarkGray
    exit 0
}

Write-Host "`nFiles to deploy ($($filesToDeploy.Count)):" -ForegroundColor Yellow
$filesToDeploy | ForEach-Object { Write-Host "  + $_" -ForegroundColor DarkGray }

# ─── UPLOAD FILES ─────────────────────────────────────
Write-Host "`nUploading..." -ForegroundColor Yellow
$uploaded = 0
$failed = 0

foreach ($relPath in $filesToDeploy) {
    $localFile = Join-Path $LOCAL_PATH $relPath
    $remoteFull = "$REMOTE_PATH/$($relPath.Replace('\', '/'))"
    $remoteDir = ($relPath.Replace("\", "/") -replace '/[^/]+$', '')

    if (-not (Test-Path $localFile)) {
        Write-Host "  [SKIP] $relPath (not found)" -ForegroundColor DarkYellow
        continue
    }

    # Create remote directory
    if ($remoteDir -and $remoteDir -ne $relPath.Replace("\", "/")) {
        Invoke-Remote "mkdir -p $REMOTE_PATH/$remoteDir" | Out-Null
    }

    # Upload file
    try {
        $result = Upload-File $localFile $remoteFull
        if ($LASTEXITCODE -eq 0) {
            Write-Host "  [OK] $relPath" -ForegroundColor Green
            $uploaded++
        } else {
            Write-Host "  [FAIL] $relPath" -ForegroundColor Red
            $failed++
        }
    } catch {
        Write-Host "  [FAIL] $relPath - $_" -ForegroundColor Red
        $failed++
    }
}

# ─── POST-DEPLOY: Clear caches ───────────────────────
Write-Host "`nClearing server caches..." -ForegroundColor Yellow
Invoke-Remote "cd $REMOTE_PATH && rm -rf bootstrap/cache/*.php 2>/dev/null; php artisan config:clear 2>&1; php artisan cache:clear 2>&1; php artisan view:clear 2>&1; echo CACHE_CLEARED" | Out-Null
Write-Host "[OK] Caches cleared." -ForegroundColor Green

# ─── SUMMARY ─────────────────────────────────────────
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  DEPLOY COMPLETE!" -ForegroundColor Green
Write-Host "  Uploaded: $uploaded  |  Failed: $failed" -ForegroundColor White
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
