# This Justfile contains recipes for managing the HMCTS DTS Developer Challenge - Junior project
#
# To use this Justfile, ensure you have Just installed: https://just.systems/

# Start the development environment
start:
    @docker compose up -d

# Stop the development environment
stop:
    @docker compose down

# Run a command inside the API container
api +cmd:
    @docker compose run --rm api bash -c "{{cmd}}"

# Install dependencies
install:
    @docker compose run --rm api composer install

# Run database migrations
migrate:
    @docker compose run --rm api php yii migrate

# Run phpcs (linting and style checking)
phpcs *args:
    @docker compose run --rm api composer run phpcs -- -p -n --standard=phpcs.xml {{args}}

# Run psalm (static analysis)
psalm *args:
    @docker compose run --rm api composer run psalm -- {{args}}

# Run Codeception (tests)
codecept *args:
    @docker compose run --rm api composer run codecept -- {{args}}

# Open Yii2 debug's UI in the default browser
debug:
    @open http://localhost:8000/debug
