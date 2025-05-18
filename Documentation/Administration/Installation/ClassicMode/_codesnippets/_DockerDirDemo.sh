mkdir -p typo3demo
cd typo3demo
mkdir -p fileadmin typo3conf typo3temp
# Ensure TYPO3 can write to these directories
chmod -R 777 fileadmin typo3conf typo3temp
