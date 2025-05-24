# Stop and remove containers
docker stop typo3-demo typo3db || true
docker rm typo3-demo typo3db || true

# Remove the Docker network
docker network rm typo3-demo-net || true

# Remove project folders, you need root access for this
sudo rm -rf fileadmin typo3conf typo3temp uploads

# Optionally remove Docker images (uncomment if desired)
# docker rmi martinhelmich/typo3
# docker rmi mariadb
