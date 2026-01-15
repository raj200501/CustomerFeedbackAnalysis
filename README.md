# Customer Feedback Analysis System

The Customer Feedback Analysis System is a PHP + SQLite application that lets teams collect customer feedback, automatically extract keywords, compute a lightweight sentiment score, and review/administer responses. The repository now includes runnable scripts, deterministic verification, and CI.

## Features

- **Submit Feedback:** Capture feedback with rating and type.
- **View Feedback:** Browse feedback entries with extracted keywords and admin responses.
- **Feedback Analytics:** Automatic keyword extraction and sentiment scoring per feedback entry.
- **Admin Management:** Respond to and delete feedback, plus review customers and responders.
- **User Roles:** Seeded admin/manager accounts to support response attribution (no login required for demo).

## Requirements

- PHP 8.1+ with PDO SQLite enabled
- `curl` (used by the verification script)

## Verified Quickstart (runnable)

```bash
# from the repo root
./scripts/run.sh
```

Then open: <http://localhost:8000>

### Default data and responders

The database is automatically created at `storage/feedback.sqlite` and seeded with sample feedback and responder accounts:

| Username | Role | Password |
| --- | --- | --- |
| admin | admin | adminpass |
| manager | manager | managerpass |
| support | manager | supportpass |

> ⚠️ There is no login screen; responders are only used to attribute responses in the admin UI.

## Configuration

Create a `.env` file (optional). Defaults are shown in `.env.example`.

- `DB_PATH`: Path to SQLite database (default `storage/feedback.sqlite`)
- `APP_ENV`: `development` or `test`
- `BASE_PATH`: Base URL path when running under a subdirectory (default `/`)
- `SEED_ON_BOOT`: `true` or `false` to control sample data seeding

## Verified Verification (CI entrypoint)

```bash
./scripts/verify.sh
```

This command is what CI runs. It will:

1. Create a fresh SQLite database.
2. Run unit/integration tests (`php tests/run.php`).
3. Start the PHP built-in server and exercise the app with `curl`.
4. Confirm the analytics page includes the newly extracted keyword.

## Manual QA Commands

```bash
# create or reset the database
SEED_ON_BOOT=true php scripts/setup_db.php

# start the server if you want to point it at a custom DB
DB_PATH=storage/custom.sqlite ./scripts/run.sh
```

## Troubleshooting

- **PDO SQLite missing:** install the PHP SQLite extension (e.g., `apt-get install php-sqlite3`).
- **Port 8000 in use:** run `PORT=8001 ./scripts/run.sh` and set `BASE_PATH=/` when using a reverse proxy.
- **Data duplication:** set `SEED_ON_BOOT=false` to avoid re-seeding a database.

## Project Layout

- `public/` – PHP entrypoints and static assets
- `src/` – application services, repositories, and validation
- `sql/` – schema and seed data
- `tests/` – unit + integration tests with a lightweight runner
- `scripts/` – run and verification entrypoints
- `.github/workflows/ci.yml` – CI workflow

## README Truth Contract

The commands above were executed successfully in this environment. The verification script matches what CI runs and includes a real HTTP smoke test that checks feedback submission and analytics output.
