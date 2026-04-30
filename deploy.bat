@echo off
echo ========================================
echo   ANIMAZON DEPLOYER
echo ========================================
echo.

REM Check if arguments were passed
if "%~1"=="" (
    echo Deploying changed files...
    powershell.exe -ExecutionPolicy Bypass -File "%~dp0deploy.ps1"
) else (
    echo Deploying with args: %*
    powershell.exe -ExecutionPolicy Bypass -File "%~dp0deploy.ps1" %*
)

echo.
