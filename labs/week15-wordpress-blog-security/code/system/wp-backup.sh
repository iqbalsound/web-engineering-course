#!/usr/bin/env bash
set -euo pipefail
WEBUSER="${WEBUSER:-apache}"; WP=/var/www/webeng/wp; OUT=/var/backups/webeng; TS=$(date +%Y%m%d-%H%M)
runuser -u "$WEBUSER" -- env WP_CLI_CACHE_DIR=/tmp/wp-cli-cache wp --path="$WP" db export "/tmp/db-$TS.sql"
mv "/tmp/db-$TS.sql" "$OUT/"
tar czf "$OUT/wp-files-$TS.tgz" -C /var/www/webeng wp
find "$OUT" -type f -mtime +14 -delete
(cd "$OUT" && sha256sum "db-$TS.sql" "wp-files-$TS.tgz" > "SHA256-$TS.txt")
echo "backup $TS complete"
