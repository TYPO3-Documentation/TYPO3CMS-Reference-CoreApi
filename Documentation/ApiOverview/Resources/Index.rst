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

..  _resources-definitions:

Configuring the resource folders of a package with resource definitions
=======================================================================

..  versionadded:: 14.2
    :changelog: feature-109409-1774770383

Resource definitions state which folders and files of a package
:ref:`resource identifiers <resources-identifiers>` can reference, and which
of them TYPO3 publishes to the :folder:`public/_assets` folder.

By default, an extension has two resource definitions: the private folder
:folder:`Resources/Private`, and the public folder :folder:`Resources/Public`
if it exists. TYPO3 publishes :folder:`Resources/Public` the same way as
before resource definitions existed.

..  deprecated:: 14.2
    :changelog: deprecation-109409-1774787352

    A resource identifier that references a path of an extension outside its
    resource definitions triggers a deprecation message. Add a resource
    definition for the path, or move the file into a folder that is
    already defined. Configuration files that TYPO3 loads itself, such as
    YAML files or TypoScript and TSconfig includes, are not affected.

..  _resources-definitions-extension:

Resource definitions of an extension in `Configuration/Resources.php`
---------------------------------------------------------------------

To add resource definitions to an extension, create the file
:file:`Configuration/Resources.php`. It returns a closure that receives the
:php-short:`\TYPO3\CMS\Core\Package\Package` and returns a list of resource
definitions. TYPO3 adds them to the default definitions:

..  literalinclude:: _CodeSnippets/_ExtensionResources.php
    :caption: EXT:my_extension/Configuration/Resources.php

:php-short:`\TYPO3\CMS\Core\Package\Resource\Definition\PublicResourceDefinition`
    A public folder. TYPO3 publishes it below :folder:`public/_assets`, in
    a folder with a hash as its name, unless `publicPrefix` names the
    folder.

:php-short:`\TYPO3\CMS\Core\Package\Resource\Definition\PublicFileDefinition`
    A single public file. TYPO3 publishes it in a folder with a hash as
    its name, unless `publicPrefix` names the folder.

:php-short:`\TYPO3\CMS\Core\Package\Resource\Definition\ResourceDefinition`
    A private folder. Resource identifiers can reference its files on the
    server side, but TYPO3 does not publish it.

The argument `publicPrefix` of
:php-short:`\TYPO3\CMS\Core\Package\Resource\Definition\PublicResourceDefinition::__construct()`
replaces the hash with a fixed path below
:folder:`public/_assets`. A fixed public prefix must be unique across all
packages. TYPO3 throws an exception if two packages use the same one.

..  _resources-definitions-project:

Resource definitions of the project in `config/system/resources.php`
--------------------------------------------------------------------

The project itself is the virtual package `typo3/app`. By default, its
resource definitions are these public folders:

*   :folder:`public/_assets`
*   :folder:`public/uploads`
*   :folder:`public/typo3temp/assets`

To add resource definitions to the project, create the file
:file:`config/system/resources.php`. The closure receives the virtual
package and the path of the public folder relative to the project root.
The paths of the definitions are relative to the project root as well:

..  literalinclude:: _CodeSnippets/_ProjectResources.php
    :caption: config/system/resources.php

Do not put files into :folder:`public/_assets` yourself. Keep them in a folder
outside the public folder and add a resource definition, so that TYPO3
publishes them. A publisher of a third-party extension can then publish
them to another location, for example a CDN. TYPO3 does not publish a folder
that is already inside the public folder.

..  _resources-definitions-rules:

Rules for both files
--------------------

*   In Composer mode, TYPO3 is not bootstrapped when it reads these files.
    Only autoloading works, there is no global state. Use plain PHP, and
    files inside the package folder.
*   A path must not start or end with a slash, and must not contain `../`.
*   After you change a resource definition, run :bash:`composer dumpautoload`
    in Composer mode, or flush the caches in classic mode.

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
    :changelog: feature-107537-1759136314

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

`https://example.org/css/main.css`, `//example.org/css/main.css` or `URI:/css/main.css`
    A URL, a protocol-relative URL, or a URL relative to the current host.
    An invalid URL never ends up in the HTML. The PHP API, for example the
    asset collector, throws an exception. The :typoscript:`PAGE` include
    properties, such as :typoscript:`includeCSS`, leave the file out.

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

The ViewHelper `f:uri.resource` accepts a resource identifier directly in its
`path` attribute (`path="PKG:..."`). Alternatively, an identifier can be
converted into a resource object using `f:resource`, for example when chaining
ViewHelpers:

..  literalinclude:: _CodeSnippets/_MapResource.fluid.html
    :caption: packages/my_extension/Resources/Private/Content/Map.fluid.html

If the assets lie within the same extension you can also use relative paths in
the JavaScript and CSS files.

..  _resources-public-php:

Generating the URL of a public resource in PHP
----------------------------------------------

..  versionadded:: 14.0
    :changelog: feature-107537-1759136314

To get the URL of a public resource in PHP, resolve its
:ref:`resource identifier <resources-identifiers>` with the
:php:`\TYPO3\CMS\Core\SystemResource\SystemResourceFactory` and pass the
result to an implementation of
:php:`\TYPO3\CMS\Core\SystemResource\Publishing\SystemResourcePublisherInterface`.
It returns a URL that works in Composer and classic mode alike, with a cache
buster, because `cacheBusting` defaults to `true`:

..  literalinclude:: _CodeSnippets/_MyMapController.php
    :caption: packages/my_extension/Classes/Controller/MyMapController.php

Pass `null` as request only where there is no request, for example in a
console command. Absolute URLs cannot be generated then. To leave out the
cache buster, pass :php:`new UriGenerationOptions(cacheBusting: false)`.

:php:`createPublicResource()` throws an exception if the resource is not
public, for example a Fluid template in :folder:`Resources/Private`. Use
:php:`createResource()` to resolve such a resource, for example to read it
on the server side.
