#!/bin/bash
# Runs ON the production server right after the new code has been rsynced in.
# Clears the stale compiled cache that has caused 500 errors before,
# installs PHP deps under PHP 8.2, migrates, rebuilds caches, and restarts queue workers.
set -e

cd "$DEPLOY_PATH"

PHP_BIN="/opt/alt/php82/usr/bin/php"
echo "Using PHP binary: $PHP_BIN"

echo "Clearing stale compiled cache (bootstrap/cache/*.php)..."
find bootstrap/cache -maxdepth 1 -name "*.php" -delete

echo "Installing PHP dependencies under PHP 8.2..."
if [ -f composer.phar ]; then
    "$PHP_BIN" composer.phar install --no-dev --optimize-autoloader --no-interaction
elif command -v composer >/dev/null 2>&1; then
    "$PHP_BIN" "$(command -v composer)" install --no-dev --optimize-autoloader --no-interaction
else
    echo "ERROR: no composer available on server (expected composer.phar in home dir)"
    exit 1
fi

echo "Running migrations..."
"$PHP_BIN" artisan migrate --force

echo "Running ProposalSeeder to ensure proposals exist in production DB..."
"$PHP_BIN" artisan db:seed --class=ProposalSeeder --force || true

echo "Rebuilding caches..."
"$PHP_BIN" artisan config:cache
"$PHP_BIN" artisan route:cache
"$PHP_BIN" artisan view:cache

echo "Restarting queue workers (no-op if none configured)..."
"$PHP_BIN" artisan queue:restart || true

echo "Post-deploy steps complete."
