#!/usr/bin/env bash
#
# Sets up a TYPO3 instance from .Build with SQLite and takes the
# screenshots. Called by Build/Scripts/runTests.sh, which provides the
# container commands:
#
#   PHP_RUN        runs a command in the PHP container
#   WEB_START      starts the PHP web server container in the background
#   WEB_STOP       stops it again
#   BROWSER_RUN    runs a command in the Playwright container next to it
#
set -e

rm -rf config var .Build/web/fileadmin .Build/web/typo3temp
${PHP_RUN} .Build/bin/typo3 setup --no-interaction --force \
    --driver=sqlite \
    --admin-username=j.doe --admin-user-password='Screenshots-2026!' \
    --admin-email=j.doe@example.org \
    --project-name='TYPO3 Explained' \
    --create-site='http://localhost:8080/' \
    --server-type=other
${PHP_RUN} .Build/bin/typo3 extension:setup
# The PHP web server provides no SERVER_NAME to compare the host with
${PHP_RUN} .Build/bin/typo3 configuration:set SYS/trustedHostsPattern '.*'
# The folder for temporary files is missing, as in the screenshot of the
# directory status
rm -rf .Build/web/fileadmin/_temp_

${WEB_START}
trap '${WEB_STOP}' EXIT
${BROWSER_RUN} sh -c "npm ci --no-audit --no-fund && node screenshots.mjs $*"
