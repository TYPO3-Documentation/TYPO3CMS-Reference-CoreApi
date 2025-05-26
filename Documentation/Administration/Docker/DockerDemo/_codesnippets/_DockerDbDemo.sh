docker run -d --name typo3db --network typo3-demo-net \
    -e MYSQL_ROOT_PASSWORD=secret \
    -e MYSQL_DATABASE=db \
    -e MYSQL_USER=db \
    -e MYSQL_PASSWORD=db \
    mariadb:latest
