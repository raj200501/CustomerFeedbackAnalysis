#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
export DB_PATH="${DB_PATH:-$ROOT_DIR/storage/feedback.sqlite}"
export APP_ENV="${APP_ENV:-development}"
export BASE_PATH="${BASE_PATH:-/}"
export SEED_ON_BOOT="${SEED_ON_BOOT:-true}"
PORT="${PORT:-8000}"

php "$ROOT_DIR/scripts/setup_db.php" >/dev/null

echo "Starting server on http://localhost:${PORT}"
php -S 0.0.0.0:"${PORT}" -t "$ROOT_DIR/public"
