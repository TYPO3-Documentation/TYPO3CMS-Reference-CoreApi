docker run -d -p 8080:80 --name typo3-demo --network typo3-demo-net \
    -v "$(pwd)/fileadmin:/var/www/html/fileadmin" \
    -v "$(pwd)/typo3conf:/var/www/html/typo3conf" \
    -v "$(pwd)/typo3temp:/var/www/html/typo3temp" \
    -e TYPO3_CONTEXT=Development/Docker \
    -e PHP_DISPLAY_ERRORS=1 \
    martinhelmich/typo3
