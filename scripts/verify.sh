#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
VERIFY_DB="$ROOT_DIR/storage/verify_feedback.sqlite"

export DB_PATH="$VERIFY_DB"
export APP_ENV=test
export BASE_PATH=/
export SEED_ON_BOOT=true

rm -f "$VERIFY_DB"
php "$ROOT_DIR/scripts/setup_db.php"

php "$ROOT_DIR/tests/run.php"

SERVER_LOG="$ROOT_DIR/storage/verify_server.log"
php -S 127.0.0.1:8000 -t "$ROOT_DIR/public" >"$SERVER_LOG" 2>&1 &
SERVER_PID=$!

cleanup() {
    kill "$SERVER_PID" >/dev/null 2>&1 || true
}
trap cleanup EXIT

READY=false
for _ in {1..20}; do
    if curl -fsS "http://127.0.0.1:8000/index.php" >/dev/null 2>&1; then
        READY=true
        break
    fi
    if ! kill -0 "$SERVER_PID" >/dev/null 2>&1; then
        echo "Server failed to start. Logs:" >&2
        cat "$SERVER_LOG" >&2
        exit 1
    fi
    sleep 0.2
done

if [ "$READY" != "true" ]; then
    echo "Server did not become ready. Logs:" >&2
    cat "$SERVER_LOG" >&2
    exit 1
fi

curl -fsS "http://127.0.0.1:8000/index.php" | grep -q "Customer Feedback Analysis System"

curl -fsS -X POST \
    -d "name=Verify%20User" \
    -d "email=verify@example.com" \
    -d "feedback=Amazing%20service%20with%20fast%20and%20friendly%20support" \
    -d "rating=5" \
    -d "feedback_type=Service" \
    "http://127.0.0.1:8000/submit_feedback.php" | grep -q "Thanks for your feedback"

curl -fsS "http://127.0.0.1:8000/analytics.php" | grep -q "amazing"

echo "Verification complete."
