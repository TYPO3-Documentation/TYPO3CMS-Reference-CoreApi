:navigation-title: Composer on the server

..  include:: /Includes.rst.txt
..  _direct-server-composer-access:

============================================
Finding or installing Composer on the server
============================================

If `composer` is not found when you run it, you may need to use a full path or
install it manually.

**Try finding the PHP and Composer paths** using `which`:

..  code-block:: bash

    $ which php
    /opt/php-8.3/bin/php
    $ which composer
    /usr/local/bin/composer

Use full paths instead of just `composer`, for example:

..  code-block:: bash

    /opt/php-8.3/bin/php /usr/local/bin/composer create-project \
        "typo3/cms-base-distribution:^13.4" my-new-project

**If Composer is not installed**, you can download it here:
`https://getcomposer.org/download/ <https://getcomposer.org/download/>`_

Then run it like this:

.. code-block:: bash

    /opt/php-8.3/bin/php composer.phar create-project \
        "typo3/cms-base-distribution:^13.4" my-new-project

Refer to your hosting provider’s documentation if you have multiple PHP
versions or need special access.

Example:
`Use specific PHP versions in the console (jweiland.net)
<https://jweiland.net/en/hosting/anleitungen-cloud-hosting/spezifische-php-versionen-in-der-konsole-verwenden.html>`_
