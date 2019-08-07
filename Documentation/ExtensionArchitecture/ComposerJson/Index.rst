.. include:: ../../Includes.txt


.. _composer-json:

=====================
composer.json
=====================

*-- required*

.. note::

   While the file :file:`composer.json` is currently not strictly required, it is considered
   bad practice not to add one. That is why we classify it as "required".

Including a :file:`composers.json` is strongly recommended for a number of reasons:

#. The file :file:`composer.json` is required for documentation rendering since
   May 29, 2019.

   See :ref:`h2document:migrate` for more information on the necessary changes for
   extension documentation rendering.

#. Working with Composer in general is strongly recommended for TYPO3.

   If you are not using Composer for your projects yet, see :ref:`t3install:migrate-to-composer`
   in the "Installation & Upgrade Guide".


Minimal composer.json
=====================

This is a minimal composer.json for a TYPO3 extensions:

.. code-block:: json
   :linenos:

   {
       "name": "vendor/package-key",
       "type": "typo3-cms-extension",
       "description": "An example extension",
       "license": "GPL-2.0-or-later",
       "require": {
           "typo3/cms-core": "^8.7.8"
       },
       "extra": {
           "typo3/cms": {
               "extension-key": "extension_key"
           }
       }
   }

* **name** (*required*): `<vendor name>/<dashed extension key>` "Dashed extension key" means that every
  underscore (`_`) has been changed to a dash (`-`).
  You must be owner of the vendor name and should register it on packagist. Typically, the name will
  correspond to your namespaces used in the :file:`Classes` folder, but with different uppercase /
  lowercase spelling, e.g. `GeorgRinger\News` namespace and `georgringer/news` name in :file:`composer.json`.
* **type** (*required*): Just use `typo3-cms-extension` for TYPO3 extensions
* **description** (*required*): Description of your extension (1 line)
* **license** (*recommended*)
* **require** (*required*): At the least, you will want to require `typo3/cms-core`. You can add other
  system extensions and third party extensions, if your extension depends on them.
* **extra** (*optional*): The extra typo3/cms section can be used to provide a TYPO3 extension_key for the package.
  This will be used when found. If not provided, the package-key will be used with all dashes (`-`)
  replaced by underscores (`_`) to follow TYPO3 and packagist conventions.


Properties not used:

* **version** (*not recommended*): was used in earlier TYPO3 versions. For versions 7.6 and above
  you should not use the version property. The version for the extension is set in the file
  :ref:`ext_emconf.php <ext_emconf-php>`.



More Information
================

Not TYPO3 specific:

* `About Packagist <https://packagist.org/about>`__
* `composer.json schema <https://getcomposer.org/doc/04-schema.md>`__
* `Composer Getting Started <https://getcomposer.org/doc/00-intro.md>`__

