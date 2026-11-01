#!/bin/bash
# Run the TLS integration harness with Docker.
#
# This command generates an ephemeral local CA and server certificates, starts
# an HTTPS mock Redsys endpoint, and verifies three certificate verification
# outcomes:
#
#   1. Trusted custom CA connects successfully.
#   2. Unknown CA is rejected.
#   3. Hostname mismatch is rejected.
#
# No private keys or certificates are committed; everything is created in a
# temporary directory inside the container and removed automatically.
#
# Usage:
#   ./test-tls-docker.sh [PHP_VERSION]
#
# Example:
#   ./test-tls-docker.sh 8.4

set -euo pipefail

PHP_VERSION=${1:-8.4}
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "Running TLS integration harness with PHP ${PHP_VERSION}..."

docker run --rm \
    -u "$(id -u):$(id -g)" \
    --add-host sermepa-tls.test:127.0.0.1 \
    --add-host wrong.sermepa-tls.test:127.0.0.1 \
    -v "${SCRIPT_DIR}:/app" \
    -w /app \
    -e COMPOSER_HOME=/tmp/composer \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    "php:${PHP_VERSION}-cli" sh -c "
    set -e
    COMPOSER_DIR=/tmp/composer/bin
    mkdir -p \"\$COMPOSER_DIR\"
    php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"
    php composer-setup.php --install-dir=\"\$COMPOSER_DIR\" --filename=composer
    php -r \"unlink('composer-setup.php');\"
    php \"\$COMPOSER_DIR/composer\" install --no-interaction
    php tests/fixtures/tls/run-tls-harness.php
"
