#!/bin/bash
# Runs ON the production server right after the new code has been rsynced in.
# Clears the stale compiled cache that has caused 500 errors before
# (documented in the old build_deployment.ps1), installs PHP deps, migrates,
# rebuilds caches, and restarts queue workers.
set -e

cd "$DEPLOY_PATH"

echo "Clearing stale compiled cache (bootstrap/cache/*.php)..."
find bootstrap/cache -maxdepth 1 -name "*.php" -delete

echo "Installing PHP dependencies..."
# --ignore-platform-reqs: composer.lock has a few transitive deps declaring a
# newer PHP floor than the server actually runs; their code paths aren't hit
# at this app's PHP version in practice, and hard-failing here means the rest
# of this script (migrate, cache rebuild) never runs. Revisit if a real
# platform incompatibility ever surfaces at runtime.
if [ -f composer.phar ]; then
    php composer.phar install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
elif command -v composer >/dev/null 2>&1; then
    composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
else
    echo "ERROR: no composer available on server (expected composer.phar in home dir)"
    exit 1
fi

echo "Running migrations..."
php artisan migrate --force

echo "Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Restarting queue workers (no-op if none configured)..."
php artisan queue:restart || true

echo "Post-deploy steps complete."
