.. include:: ../../Includes.txt


.. _composer-json:

=====================
composer.json
=====================

*-- required*

.. note::

   While the file :file:`composer.json` is currently not strictly required
   for an extension to function properly, it is considered
   bad practice not to add one. That is why we classify it as "required".

Including a :file:`composer.json` is strongly recommended for a number of reasons:

#. The file :file:`composer.json` is required for documentation rendering since
   May 29, 2019.

   See :ref:`h2document:migrate` for more information on the necessary changes for
   extension documentation rendering.

#. Working with Composer in general is strongly recommended for TYPO3.

   If you are not using Composer for your projects yet, see :ref:`t3install:migrate-to-composer`
   in the "Installation & Upgrade Guide".


Minimal composer.json
=====================

This is a minimal composer.json for a TYPO3 extension:

* The vendor name is *Vendorname*
* The extension key is *my_extension*

Subsequently:

* The namespace will be *Vendorname\\MyExtension*
* The package name will be *vendorname/my-extension*

.. code-block:: json
   :linenos:

   {
       "name": "vendorname/my-extension",
       "type": "typo3-cms-extension",
       "description": "An example extension",
       "license": "GPL-2.0-or-later",
       "require": {
           "typo3/cms-core": "^9.5 || ^10.4"
       },
       "replace": {
           "vendorname/my-extension": "self.version",
           "typo3-ter/my-extension": "self.version"
       },
       "extra": {
           "typo3/cms": {
               "extension-key": "my_extension"
           }
       },
       "autoload": {
           "psr-4": {
               "Vendorname\\MyExtension\\": "Classes/"
           }
       }
   }

``name`` (*required*)
   `<vendorname>/<dashed extension key>` "Dashed extension key" means that every underscore (`_`) has been changed to a dash (`-`).
   You must be owner of the vendor name and should register it on packagist.
   Typically, the name will correspond to your namespaces used in the :file:`Classes` folder,
   but with different uppercase / lowercase spelling,
   e.g. `GeorgRinger\News` namespace and `georgringer/news` name in :file:`composer.json`.

``type`` (*required*)
   Just use `typo3-cms-extension` for TYPO3 extensions

``description`` (*required*)
   Description of your extension (1 line)

``license`` (*recommended*)
   Has to be `GPL-2.0-only` or `GPL-2.0-or-later`.
   See: https://typo3.org/project/licenses/.

``require`` (*required*)
   At the least, you will want to require `typo3/cms-core`.
   You can add other system extensions and third party extensions,
   if your extension depends on them.

``replace``
  The replace part allows you to modify the extension locally and to avoid conflicts with a code for 
  this extension coming from an external repository.

``extra``
   The extra `typo3/cms` section can be used to provide a TYPO3 extension_key for the package.
   This will be used when found. If not provided, the package-key will be used with all dashes (`-`)
   replaced by underscores (`_`) to follow TYPO3 and Packagist conventions.

``autoload``
   Define namespace - path mapping for PSR-4 autoloading.
   In TYPO3 we follow the convention that all classes (except test classes)
   are in the directory :file:`Classes`.

Properties no longer used:

``version`` (*not recommended*)
  Was used in earlier TYPO3 versions.
  For versions 7.6 and above you should not use the version property.
  The version for the extension is set in the file :ref:`ext_emconf.php <ext_emconf-php>`.

More Information
================

Not TYPO3 specific:

* `About Packagist <https://packagist.org/about>`__
* `composer.json schema <https://getcomposer.org/doc/04-schema.md>`__
* `Composer Getting Started <https://getcomposer.org/doc/00-intro.md>`__

TYPO3 specific:

* The :ref:`section on testing <testing-extensions>` (in this manual) contains further information
  about adding additional properties to :file:`composer.json` that are relevant for testing.
* `Helmut Hummel: composer.json specification for TYPO3 extensions <https://insight.helhum.io/post/148886148725/composerjson-specification-for-typo3-extensions>`__
* `Helmut Hummel: minimal composer.json <https://gist.github.com/helhum/0ffd82525c90f305b81a8285329eb4f8>`__
* `Helmut Hummel: TYPO3 Extension dependencies revisited <https://insight.helhum.io/post/155297666635/typo3-extension-dependencies-revisited>`__
* `Daniel Goerz: COMPOSER AND TYPO3 7LTS AND 8LTS  <https://usetypo3.com/typo3-and-composer.html>`__ (last updated: August 24, 2019)
