#!/usr/bin/env bash
#
# Sets up a TYPO3 instance from .Build with SQLite and the demo site of the
# Camino theme, like the Editors Tutorial, adds the records of
# create-records.php and takes the screenshots. Called by
# Build/Scripts/runTests.sh, which provides the container commands:
#
#   PHP_RUN        runs a command in the PHP container
#   WEB_START      starts the PHP web server container in the background
#   WEB_STOP       stops it again
#   BROWSER_RUN    runs a command in the Playwright container next to it
#
set -e

rm -rf config var .Build/web/fileadmin .Build/web/typo3temp
# The steps of the installer, in the instance before it is set up
touch .Build/web/FIRST_INSTALL
${WEB_START}
trap '${WEB_STOP}' EXIT
# Playwright is installed once, so later runs work without the network
${BROWSER_RUN} sh -c "( [ -d node_modules/playwright ] || npm ci --no-audit --no-fund ) && node screenshots.mjs --stage=install $*"
${WEB_STOP}
rm -rf config var .Build/web/FIRST_INSTALL .Build/web/fileadmin .Build/web/typo3temp
${PHP_RUN} .Build/bin/typo3 setup --no-interaction --force \
    --driver=sqlite \
    --admin-username=j.doe --admin-user-password='Screenshots-2026!' \
    --admin-email=j.doe@example.org \
    --project-name='TYPO3 Explained' \
    --distribution=theme_camino \
    --server-type=other
${PHP_RUN} .Build/bin/typo3 extension:setup
# The PHP web server provides no SERVER_NAME to compare the host with
${PHP_RUN} .Build/bin/typo3 configuration:set SYS/trustedHostsPattern '.*'
# The folder for temporary files is missing, as in the screenshot of the
# directory status
rm -rf .Build/web/fileadmin/_temp_
# Shows the field names in brackets next to the labels
${PHP_RUN} .Build/bin/typo3 configuration:set BE/debug 1
# A custom language and an overridden label, as on the page about managing
# translations, with the translation file of the custom language from there
cp Build/Screenshots/additional.php config/system/additional.php
mkdir -p var/labels/gsw_CH/setup/Resources/Private/Language
cp Documentation/ApiOverview/Localization/_snippets/_gsw_CH.locallang_2.0.xlf \
    var/labels/gsw_CH/setup/Resources/Private/Language/gsw_CH.locallang.xlf
# Spanish is active in the language packs, without its translations, which
# would need the network
${PHP_RUN} .Build/bin/typo3 configuration:set LANG/availableLocales '["es"]' --json
${PHP_RUN} php Build/Screenshots/create-records.php
# The file that the screenshot of the import preview imports
${PHP_RUN} .Build/bin/typo3 impexp:export --type=xml --pid=1 --levels=999 --table=_ALL camino

${WEB_START}
${BROWSER_RUN} node screenshots.mjs $*
# The users and groups of the naming conventions show only in their own
# screenshots, which follow once they are added
${PHP_RUN} php Build/Screenshots/create-records.php naming
${BROWSER_RUN} node screenshots.mjs --stage=naming $*
# The upgrade wizards that have not run yet show only in their own
# screenshot
${PHP_RUN} php Build/Screenshots/create-records.php upgrade
${BROWSER_RUN} node screenshots.mjs --stage=upgrade $*
# The users of multi-factor authentication and the site with the missing
# set show only in their own screenshots, the last ones
${PHP_RUN} php Build/Screenshots/create-records.php last
${BROWSER_RUN} node screenshots.mjs --stage=last $*
