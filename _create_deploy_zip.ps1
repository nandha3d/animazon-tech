$src = "d:\PROJECTS\WEBSITES\_deploy_temp"
$zipPath = "d:\PROJECTS\WEBSITES\animazon-tech-deploy.zip"

# Remove old zip
Remove-Item $zipPath -ErrorAction SilentlyContinue

# If temp dir doesn't exist (from previous robocopy), create it
if (-not (Test-Path $src)) {
    Write-Host "Copying files..."
    $origSrc = "d:\PROJECTS\WEBSITES\animazon-tech"
    robocopy $origSrc $src /E /XD node_modules .git .gemini tests /NFL /NDL /NJH /NJS /NC /NS /NP | Out-Null
}

Write-Host "Creating zip with .NET ZipFile (fast)..."
Add-Type -Assembly "System.IO.Compression.FileSystem"
[System.IO.Compression.ZipFile]::CreateFromDirectory($src, $zipPath, [System.IO.Compression.CompressionLevel]::Fastest, $false)

# Clean temp
Remove-Item $src -Recurse -Force

$fileSize = (Get-Item $zipPath).Length / 1MB
Write-Host "Done! Zip: $zipPath"
Write-Host "Size: $([math]::Round($fileSize, 1)) MB"
