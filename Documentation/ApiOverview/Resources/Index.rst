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
=====================================================

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

..  _resources-identifiers:

Resource identifiers: referencing files with `EXT:`, `PKG:`, `FAL:` and URLs
============================================================================

..  versionadded:: 14.0
    See `Feature: #107537 - System resource API for system file access and
    public URI generation
    <https://docs.typo3.org/permalink/changelog:feature-107537-1759136314>`_.

Where TYPO3 resolves a system resource, for example in the TypoScript
property :typoscript:`includeCSS`, in the `asset collector
<https://docs.typo3.org/permalink/t3coreapi:asset-collector>`_, in Fluid or
in the PHP API, it accepts these resource identifiers:

`PKG:my-vendor/my-extension:Resources/Public/Css/main.css`
    A file in a package, identified by its Composer name. This works in
    classic mode as well, if the extension has a :file:`composer.json`. The
    `EXT:` syntax can still be used for extensions.

`PKG:typo3/app:public/typo3temp/assets/style.css`
    A file of the project itself, with the virtual package name `typo3/app`
    and a path relative to the project root.

`FAL:1:/templates/css/main.css`
    A file in the :ref:`file storage <fal-architecture-components-storage>`
    with the UID `1`.

`https://example.org/css/main.css` or `URI:/css/main.css`
    A URL, or a URL relative to the current host. An invalid URL throws an
    exception instead of ending up in the HTML.

..  deprecated:: 14.0
    Referencing a file by a path relative to the public folder, such as
    `typo3temp/assets/style.css` or `_assets/vite/foo.css`, is deprecated.
    A path such as `fileadmin/file.svg` is only resolved in the default file
    storage, which is configured in
    `$GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir'] <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-be-fileadmindir>`_.
    Use one of the identifiers above instead.

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
    :caption: packages/my_extension/Resources/Private/Content/Map.fluid.html

The file paths can then be used within JavaScript:

..  literalinclude:: _CodeSnippets/_Map.js
    :caption: packages/my_extension/Resources/Public/JavaScript/Content/Map.js

To reference a resource by its
:ref:`resource identifier <resources-identifiers>`, turn it into a resource
object with the ViewHelper `f:resource` first:

..  literalinclude:: _CodeSnippets/_MapResource.fluid.html
    :caption: packages/my_extension/Resources/Private/Content/Map.fluid.html

If the assets lie within the same extension you can also use relative paths in
the JavaScript and CSS files.

..  _resources-public-php:

Generating the URL of a public resource in PHP
----------------------------------------------

..  versionadded:: 14.0
    See `Feature: #107537 - System resource API for system file access and
    public URI generation
    <https://docs.typo3.org/permalink/changelog:feature-107537-1759136314>`_.

To get the URL of a public resource in PHP, resolve its
:ref:`resource identifier <resources-identifiers>` with the
:php:`\TYPO3\CMS\Core\SystemResource\SystemResourceFactory` and pass the
result to an implementation of
:php:`\TYPO3\CMS\Core\SystemResource\Publishing\SystemResourcePublisherInterface`.
It returns a URL with a cache buster, which works in Composer and classic
mode alike:

..  literalinclude:: _CodeSnippets/_MyMapController.php
    :caption: packages/my_extension/Classes/Controller/MyMapController.php

Pass `null` as request only where there is no request, for example in a
console command. Absolute URLs cannot be generated then. To leave out the
cache buster, pass :php:`new UriGenerationOptions(cacheBusting: false)`.

:php:`createPublicResource()` throws an exception if the resource is not
public, for example a Fluid template in :folder:`Resources/Private`. Use
:php:`createResource()` to resolve such a resource, for example to read it
on the server side.
