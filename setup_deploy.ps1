$ErrorActionPreference = "Stop"

Write-Host "========================================"  -ForegroundColor Cyan
Write-Host "  ANIMAZON DEPLOY - ONE-TIME SETUP"      -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

$SSH_HOST = "217.21.74.44"
$SSH_PORT = 65002
$SSH_USER = "u362580417"
$KEY_PATH = "$env:USERPROFILE\.ssh\animazon_deploy"

# Step 1: Generate SSH key
if (Test-Path "$KEY_PATH.pub") {
    Write-Host "`n[OK] SSH key already exists at $KEY_PATH" -ForegroundColor Green
} else {
    Write-Host "`n[1/3] Generating SSH key (no passphrase)..." -ForegroundColor Yellow
    # Windows PowerShell can't pass empty -N properly, so use stdin
    echo y | ssh-keygen -t ed25519 -f $KEY_PATH -C "animazon-deploy" -q -N """"
    if (-not (Test-Path "$KEY_PATH.pub")) {
        # Fallback: try without -N and just press enter
        Write-Host "Retrying key generation... Just press ENTER twice when prompted." -ForegroundColor Yellow
        ssh-keygen -t ed25519 -f $KEY_PATH -C "animazon-deploy"
    }
    Write-Host "[OK] SSH key generated!" -ForegroundColor Green
}

# Step 2: Copy public key to server
Write-Host "`n[2/3] Copying public key to server..." -ForegroundColor Yellow
Write-Host ">>> Enter your Hostinger SSH password when prompted" -ForegroundColor DarkGray

$pubKey = (Get-Content "$KEY_PATH.pub" -Raw).Trim()
ssh -o StrictHostKeyChecking=accept-new -p $SSH_PORT "$SSH_USER@$SSH_HOST" "mkdir -p ~/.ssh && chmod 700 ~/.ssh && echo '$pubKey' >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys"

# Step 3: Test connection
Write-Host "`n[3/3] Testing passwordless connection..." -ForegroundColor Yellow
$result = ssh -o BatchMode=yes -o ConnectTimeout=10 -p $SSH_PORT -i $KEY_PATH "$SSH_USER@$SSH_HOST" "echo SUCCESS" 2>$null

if ($result -eq "SUCCESS") {
    Write-Host "`n[OK] Passwordless SSH works! Setup complete." -ForegroundColor Green
    Write-Host "You can now run: .\deploy.ps1" -ForegroundColor Cyan
} else {
    Write-Host "`n[FAIL] Key auth not working. You may need to ask Hostinger support to enable SSH key authentication." -ForegroundColor Red
}
