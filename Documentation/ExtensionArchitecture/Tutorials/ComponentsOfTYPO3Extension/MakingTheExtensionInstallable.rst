:navigation-title: composer.json

..  include:: /Includes.rst.txt
..  _making-the-extension-installable:

================================
Making the extension installable
================================

To make your TYPO3 extension installable, follow these steps:

Add `my_extension/composer.json`:

Your `composer.json` file should contain the following essential information
(for more information see :ref:`composer.json <t3coreapi:files-composer-json>`):

*   Composer name (invisible in Extension Manager)
*   Composer type
*   Extension description
*   Dependencies
*   Extension key

A minimal example:

..  literalinclude:: _composer.json
    :caption: EXT:my_extension/composer.json

Add `my_extension/Resources/Public/Icons/Extension.svg`
