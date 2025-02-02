..  include:: /Includes.rst.txt
..  index::
    Extension development; Resources/Public
    Extension Folder; Resources/Public
    Path; EXT:{extkey}/Resources/Public
..  _extension-resources-public:

========
`Public`
========

..  _extension-resources-public-assets:

Public assets
=============

Public assets used in extensions (files that should be delivered by the web
server) **must** be located in the :file:`Resources/Public` folder of the extension.

..  versionchanged:: 12.0
    Having public assets in any but the folder :file:`Resources/Public` is not
    possible anymore.

.. note::
   This folder should only be used for static assets.

   If you need to create assets during runtime, they should be stored in
   :file:`typo3temp/`.

..  _extension-resources-public-prevent-access:

Prevent access to non public files
==================================

No extension file outside the folder :file:`Resources/Public` may be accessed
from outside the web server.

This can be achieved by applying proper access restrictions on the web server.
See: :ref:`security-restrict-access-server-level`.

By using the Composer package
`helhum/typo3-secure-web <https://github.com/helhum/typo3-secure-web>` all
files except those that should be publicly available can be stored outside
the servers web root.

..  _extension-resources-public-extensions-icon:

`Resources/Public/Icons/Extension.svg`
======================================

..  typo3:file:: Extension.svg
    :scope: extension
    :path: /Resources/Public/Icons/
    :regex: /^.*\/Resources\/Public\/Icons\/Extension\.(svg|png|gif)$/
    :shortDescription: File name are reserved for the extension icon, displayed in the extension manager

    Alternatives: :file:`Resources/Public/Icons/Extension.png`,
    :file:`Resources/Public/Icons/Extension.gif`

    These file names are reserved for the extension icon, which will be displayed
    in the extension manager.

    It must be in format SVG (preferred), PNG or GIF and should have at least 16x16
    pixels.

..  _extension-resources-public-subfolders:

Common subfolders
=================

.. index::
   Path; EXT:{extkey}/Resources/Public/Css
   pair: Extensions; CSS

Resources/Public/Css
  Any CSS file used by the extension.

.. index:: Path; EXT:{extkey}/Resources/Public/Images

Resources/Public/Images
  Any image used by the extension.

.. index::
   Path; EXT:{extkey}/Resources/Public/JavaScript
   pair: Extensions; JavaScript

Resources/Public/JavaScript
  Any JS file used by the extension.
