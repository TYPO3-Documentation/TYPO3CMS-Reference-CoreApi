.. include:: /Includes.rst.txt

.. index:: php requirements, php, windows, opcode cache

.. _troubleshooting-php:

===
PHP
===

.. _troubleshooting-php-modules:

Missing PHP modules
-------------------

The "System Environment" section of the Install Tool provides detailed
information about any missing PHP modules and any other settings that
may not be configured correctly.

For example, the PHP extensions openssl and fileinfo must be enabled. This can
be achieved by adding (or uncommenting) the following lines in the [PHP]
section of your :file:`php.ini` file:

.. code-block:: none
   :caption: php.ini

   extension=fileinfo.so
   extension=openssl.so

On a Windows-based server, these are the extension files:

.. code-block:: none
   :caption: php.ini

   extension=php_fileinfo.dll
   extension=php_openssl.dll


.. _troubleshooting-php-caches-extension-classes-etc:

PHP caches, extension classes etc.
----------------------------------

There are some situations which can cause what appear to be
illogical problems after an upgrade:

- If extensions override classes in which functions have changed.
  Solution: Try disabling all extensions and then enable them one by
  one until the error recurs.

- If a PHP cache somehow fails to re-cache scripts: in particular, if a
  change happened to a parent class overridden by a child class which was not updated.
  Solution: Remove ALL cached PHP files (for PHP-Accelerator, remove :file:`/tmp/phpa_*`)
  and restart Apache.


.. _troubleshooting-php-troubleshooting_opcode:

Opcode cache messages
---------------------

..  _troubleshooting-php-troubleshooting-opcode-php-opcode:

No PHP opcode cache loaded
~~~~~~~~~~~~~~~~~~~~~~~~~~

You do not have an opcode cache system installed or activated. If you
want better performance for your website, then you should use one. The
best choice is OPcache.

..  _troubleshooting-php-troubleshooting-opcode-opcode-cache:

This opcode cache is marked as malfunctioning by the TYPO3 CMS team.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This will be shown if an opcode cache system is found and activated,
which is known to have "too many" errors and won't be supported by TYPO3
CMS (no bugfixes, security fixes or anything else). In current TYPO3
versions only OPcache is supported

..  _troubleshooting-php-troubleshooting-opcode-opcode-cache-2:

This opcode cache may work correctly but has medium performance.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This will be shown if an opcode cache system is found and activated,
which has some nitpicks. For example we cannot clear the cache for one
file (which we changed) but only can reset the complete cache itself.
This will happen with:

-  OPcache before 7.0.2 (Shouldn't be out in the wild.)
-  APC before 3.1.1 and some mysterious configuration combinations.
-  XCache
-  ZendOptimizerPlus

..  _troubleshooting-php-troubleshooting-opcode-opcode-cache-3:

This opcode cache should work correctly and has good performance.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Well it seems that all is ok and working. Maybe you can tweak something
more but this is out of our knowledge of your user scenario.
