:navigation-title: composer.json

..  include:: /Includes.rst.txt
..  _making-the-extension-installable:

================================
Making the extension installable
================================

To make your TYPO3 extension installable, follow these steps:

Add `example-extension/composer.json`:

Your `composer.json` file should contain the following essential information
(for more information see :ref:`composer.json <t3coreapi:files-composer-json>`):

*   Composer name (invisible in Extension Manager)
*   Composer type
*   Extension description
*   Dependencies
*   Extension key

A minimal example:

..  code-block:: json

    {
      "name": "vendor/example-extension",
      "description": "description for example extension",
      "type": "typo3-cms-extension",
      "require": {
        "php": "~8.2.0 || ~8.3.0",
        "typo3/cms-core": "^13.4.0",
        "typo3/cms-extbase": "^13.4.0",
        "typo3/cms-fluid": "^13.4.0",
        "typo3/cms-frontend": "^13.4.0"
      },
      "extra": {
        "typo3/cms": {
          "extension-key": "example_extension"
        }
      },
      "version":"1"
    }

Add `example-extension/Resources/Public/Icons/Extension.svg`
