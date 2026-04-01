..  include:: /Includes.rst.txt

..  index::
    ! File; EXT:{extkey}/ext_emconf.php
    File; Declaration File
..  _extension-declaration:
..  _ext_emconf-php:

================
`ext_emconf.php`
================

..  deprecated:: 14.2
    Using the `ext_emconf.php` file in extensions is deprecated. TYPO3
    extensions that still ship an `ext_emconf.php` file but **do not declare
    future compatibility to omit this file** will trigger a deprecation message
    during cache warm-up. `version` and dependency metadata should now be defined in
    the extension's `composer.json` file. The file may still need to be kept for
    compatibility with third-party tools such as TYPO3 TER and Tailor. For
    older `ext_emconf.php` documentation :ref:`see <t3coreapi/v13:ext_emconf-php>`.

..  _ext_emconf-php-migration:

Migration from `ext_emconf.php` to `composer.json`
--------------------------------------------------

Use of `ext_emconf.php` in extensions has been deprecated
(:ref:`Deprecation #108345 <changelog:deprecation-108345-1774126701>`).
If your extension needs to be compatible with TYPO3 Classic mode, add the following
to the :file:`composer.json <extension-composer-json>` file in your extension:

* Set the extension version in the `version` field. This version should
  match the version previously defined in `ext_emconf.php` and the released Git tag.
* Declare any plain (non-TYPO3 extension) Composer package dependencies (rather than on other
  TYPO3 extensions which are specified under `require`) in
  `extra.typo3/cms.Package.providesPackages`.
* If your extension does not have any Composer package dependencies, set
  `providesPackages` to an empty object. This
  avoids deprecation messages and declares future compatibility
  with TYPO3 Classic mode.

See `Classic-mode compatible composer.json <https://docs.typo3.org/permalink/t3coreapi:ext-composer-json-classic-compatible>`_
