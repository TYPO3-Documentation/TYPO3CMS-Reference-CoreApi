:navigation-title: Resource API

..  include:: /Includes.rst.txt
..  _resources:

=============
Resources API
=============

TYPO3 projects and extensions can reference two types of resource files:

Public resources that should be accessible with a browser, such as CSS and JavaScript
files, images and downloads.

Private resources that are used by server-side code, such as templates,
configuration files and localization files.

..  contents:: Table of contents

..  _resources-composer:

Location for resources in Composer-mode installations
======================================================

By default, public resources must be put into the folder
:folder:`Resources/Public` of an extension or somewhere within the web root
folder in Composer-based installations. Private resources should reside in
folder :folder:`Resources/Private` or :folder:`Configuration` of an
extension or the folders :folder:`config/sites` or :folder:`config/system`.

Images and downloads may reside in folder :folder:`public/fileadmin` or custom
file storage.

..  _resources-classic:

Resources in classic mode installations
=======================================

In TYPO3 classic mode, all files in extensions are already
located within the document root. Restricting resources to default
locations in classic mode therefore mainly follows coding guidelines
and keeps compatibility with Composer mode.

Classic mode installations should use server side access restriction, for
example by using :file:`.htaccess` or Nginx configurations. :file:`.htaccess` can
be automatically tested and adjusted:
`Verify webserver configuration (.htaccess) <https://docs.typo3.org/permalink/t3coreapi:maintain-htaccess>`_.

..  _resources-server-side:

Referencing private resources on the server side
================================================

The actual directory location where a file can be found varies from installation
to installation. It depends on the mode (Composer / Classic) and on certain
configuration, for example of the :folder:`vendor` folder. You should therefore avoid
using absolute or large relative paths like `../../../../public/_assets/12345`.

..  _resources-server-side-ext:

The `EXT:` syntax: referencing resources in extensions
------------------------------------------------------

Most API functions in PHP and TypoScript expect files to reside in extensions
and accept a syntax such as `EXT:my_extension/Resources/Private/Page/Default.html`.

They resolve the path internally. `my_extension` is the extension key as defined in
`extra.typo3/cms.extension-key <https://docs.typo3.org/permalink/t3coreapi:ext-composer-json-property-extension-key>`_
in the extension's :file:`composer.json`, the rest is the relative path from that
extension's root folder.

..  _resources-server-side-api:

Using API functionality to determine the path to a resource
-----------------------------------------------------------

In some rare cases you may need the absolute or relative path to a resource
from within your code.

:php-short:`\TYPO3\CMS\Core\Utility\GeneralUtility` offers utility method
:php:`GeneralUtility::getFileAbsFileName()` to resolve file paths:

..  literalinclude:: _CodeSnippets/_MyClass.php
    :caption: packages/my_extension/Classes/Something/MyClass.php

The `Environment PHP API <https://docs.typo3.org/permalink/t3coreapi:environment-php-api>`_
can be used to resolve paths to other locations within the project such as the
path to the :folder:`config` folder.

..  _resources-public:

Referencing public resources
============================

Public resources such as JavaScript and CSS files are usually referenced using
the `Asset collector <https://docs.typo3.org/permalink/t3coreapi:asset-collector>`_
or `f.assets.* ViewHelpers <https://docs.typo3.org/permalink/t3coreapi:assets-viewhelper>`_.

Public resources should not be referenced by their path in the :folder:`_assets`
folder as these paths contain a hash that might change during updates.

..  _resources-public-viewhelper:

Fluid ViewHelper f:uri.resource
-------------------------------

In Fluid you can use the `Uri.resource ViewHelper <f:uri.resource> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-uri-resource>`_
to reference resources. You can then provide the resource path in a data
attribute:

..  literalinclude:: _CodeSnippets/_Map.fluid.html
    :caption: packages/my_extension/Resources/Private/Content/Map.html

The file paths can then be used within JavaScript:

..  literalinclude:: _CodeSnippets/_Map.js
    :caption: packages/my_extension/Resources/Public/JavaScript/Content/Map.js

If the assets lie within the same extension you can also use relative paths in
the JavaScript and CSS files.

..  _resources-public-php:

PHP: `PathUtility::getAbsoluteWebPath()`
----------------------------------------

You can use the class :php:`\TYPO3\CMS\Core\Utility\PathUtility` to get an
absolute web path for a public resource via `PathUtility::getAbsoluteWebPath()`:

..  literalinclude:: _CodeSnippets/_MyMapController.php
    :caption: packages/my_extension/Classes/Controller/MyMapController.php
