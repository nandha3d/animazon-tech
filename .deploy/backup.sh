#!/bin/bash
# Runs ON the production server before every deploy. Takes a code + DB
# snapshot so a bad deploy can be rolled back. Never touches storage/app,
# storage/logs, or public/uploads — those are excluded from the backup's
# purpose (this backs up CODE + DB, not the already-safe runtime data).
set -e

cd "$DEPLOY_PATH"

STAMP=$(date +%Y%m%d-%H%M%S)
BACKUP_DIR="$HOME/deploy-backups/$STAMP"
mkdir -p "$BACKUP_DIR"

echo "Backing up current code to $BACKUP_DIR/code.tar.gz ..."
tar -czf "$BACKUP_DIR/code.tar.gz" \
    --exclude=storage/app \
    --exclude=storage/logs \
    --exclude=vendor \
    --exclude=node_modules \
    . 2>/dev/null || echo "WARNING: code backup had errors, continuing anyway"

if [ -f .env ]; then
    DB_DATABASE=$(grep -m1 '^DB_DATABASE=' .env | cut -d= -f2-)
    DB_USERNAME=$(grep -m1 '^DB_USERNAME=' .env | cut -d= -f2-)
    DB_PASSWORD=$(grep -m1 '^DB_PASSWORD=' .env | cut -d= -f2-)
    DB_HOST=$(grep -m1 '^DB_HOST=' .env | cut -d= -f2-)

    if [ -n "$DB_DATABASE" ]; then
        echo "Backing up database to $BACKUP_DIR/db.sql ..."
        MYSQL_PWD="$DB_PASSWORD" mysqldump -h "$DB_HOST" -u "$DB_USERNAME" "$DB_DATABASE" > "$BACKUP_DIR/db.sql" \
            || echo "WARNING: DB backup failed, continuing anyway (check DB credentials/host)"
    fi
fi

# Keep only the 10 most recent backups so this never fills the disk.
ls -1dt "$HOME"/deploy-backups/*/ 2>/dev/null | tail -n +11 | xargs -r rm -rf

echo "Backup step done: $BACKUP_DIR"
