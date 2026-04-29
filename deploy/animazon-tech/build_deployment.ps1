$ErrorActionPreference = "Stop"

$projectPath = "d:\PROJECTS\WEBSITES\animazon-tech"
$deployFolder = "$projectPath\deploy"
$deploySrc = "$deployFolder\animazon-tech"
$zipPath = "$deployFolder\animazon_deploy.zip"

Write-Host "========================================"
Write-Host "  ANIMAZON ROBUST DEPLOYMENT BUILDER"
Write-Host "========================================"

Write-Host "`n[1/5] Building frontend assets (npm run build)..."
Set-Location $projectPath
npm run build

Write-Host "`n[2/5] Preparing deploy folder..."
if (Test-Path $deployFolder) {
    Remove-Item $deployFolder -Recurse -Force -ErrorAction SilentlyContinue
}
New-Item -ItemType Directory -Path $deploySrc | Out-Null

Write-Host "`n[3/5] Copying files (Excluding local caches, .env, and dev folders)..."
# EXCLUSIONS:
# .env -> Never overwrite production environment!
# node_modules, .git, .gemini, tests -> Not needed on production
# deploy -> Exclude the deploy folder itself
# storage\framework\views, storage\framework\cache, storage\logs -> Don't copy local logs/caches
# bootstrap\cache -> CRITICAL: Don't copy local compiled config/routes to production!

robocopy $projectPath $deploySrc /E `
    /XD node_modules .git .gemini .qodo tests deploy "storage\framework\views" "storage\framework\cache" "storage\framework\sessions" "storage\logs" "bootstrap\cache" `
    /XF .env .env.backup .gitignore animazon_deploy.zip animazon-tech-deploy-fixed.zip `
    /NFL /NDL /NJH /NJS /NC /NS /NP | Out-Null

# Create empty necessary directories that were excluded
Write-Host "Re-creating empty storage & bootstrap/cache folders..."
New-Item -ItemType Directory -Path "$deploySrc\bootstrap\cache" -Force | Out-Null
New-Item -ItemType Directory -Path "$deploySrc\storage\framework\views" -Force | Out-Null
New-Item -ItemType Directory -Path "$deploySrc\storage\framework\cache" -Force | Out-Null
New-Item -ItemType Directory -Path "$deploySrc\storage\framework\sessions" -Force | Out-Null
New-Item -ItemType Directory -Path "$deploySrc\storage\logs" -Force | Out-Null
New-Item -ItemType File -Path "$deploySrc\bootstrap\cache\.gitignore" -Value "*`n!.gitignore" -Force | Out-Null

Write-Host "`n[4/5] Creating deployment zip..."
Add-Type -Assembly "System.IO.Compression.FileSystem"
[System.IO.Compression.ZipFile]::CreateFromDirectory($deploySrc, $zipPath, [System.IO.Compression.CompressionLevel]::Fastest, $false)

$fileSize = (Get-Item $zipPath).Length / 1MB
Write-Host "`n========================================"
Write-Host "✅ DEPLOYMENT BUILD COMPLETE!"
Write-Host "========================================"
Write-Host "Deploy folder : $deployFolder"
Write-Host "Zip File      : $zipPath ($([math]::Round($fileSize, 1)) MB)"
Write-Host "Extracted     : $deploySrc (Kept here for easy use!)"
Write-Host "========================================"
Write-Host "CRITICAL FIX FOR 500 ERROR ON LIVE SITE:"
Write-Host "1. Upload and extract this new zip to your server."
Write-Host "2. Ensure your server's .env file has the CORRECT production DB credentials (you may have overwritten it previously)."
Write-Host "3. On your live server, delete everything inside bootstrap/cache/ (except .gitignore)."
Write-Host "========================================"
