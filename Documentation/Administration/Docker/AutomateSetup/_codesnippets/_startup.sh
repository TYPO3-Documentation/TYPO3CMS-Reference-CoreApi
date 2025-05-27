#!/bin/bash
echo "[INFO] Running custom startup script..."

cd /var/www/html

if [ ! -f typo3conf/system/settings.php ]; then
  echo "[INFO] No settings.php found, running 'typo3 setup'..."
  gosu www-data ./typo3/sysext/core/bin/typo3 setup --no-interaction --force --server-type=apache || true
else
  echo "[INFO] settings.php found, skipping setup."
fi

exec apache2-foreground
