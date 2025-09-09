..  include:: /Includes.rst.txt

..  index::
    ! File; EXT:{extkey}/ext_emconf.php
    File; Declaration File
..  _extension-declaration:
..  _ext_emconf-php:

================
`ext_emconf.php`
================

*required* in Classic mode installations, for functional tests and to upload an
extension to the TER (TYPO3 Extension Repository)

..  typo3:file:: ext_emconf.php
    :scope: extension
    :regex: /^.*ext\_emconf\.php$/
    :shortDescription: Provides information about an extension and its dependencies in Classic mode installations and functional tests.

    The :file:`ext_emconf.php` is used in
    :ref:`Classic mode installations not based on Composer <classic-installation>` to
    supply information about an extension in the :guilabel:`Admin Tools > Extensions`
    module. In these installations the ordering of installed extensions and their
    dependencies are loaded from this file as well.

It is also needed for :ref:`Writing functional tests <t3coreapi:testing-writing-functional>`
with the `typo3/testing-framework <https://github.com/TYPO3/testing-framework>` in v8 and
earlier.

..  versionchanged:: 11.4
    In Composer-based installations, the ordering of installed extensions and
    their dependencies is loaded from the :file:`composer.json <extension-composer-json>` file, instead of
    :file:`ext_emconf.php`

The only content included is an associative array,
:php:`$EM_CONF[extension key]`. The keys are described in the table below.

This file is overwritten when extensions are imported from the online
repository. So do not write your custom code into this file - only change
values in the :php:`$EM_CONF` array if needed.

Example:

..  literalinclude:: _ExtEmconf/_ext_emconf.php
    :caption: packages/my_extension/ext_emconf.php

..  note::
    :php:`$_EXTKEY` is set globally and contains the extension key.

.. warning::

    Due to limitations of the TER (`TYPO3 Extension Repository <https://extensions.typo3.org>`__),
    `$_EXTKEY` must be used here and **not** a constant or a string. Furthermore the
    `ext_emconf.php` must not declare `strict_types=1`, otherwise TER upload will fail.

..  confval:: title
    :name: ext-emconf-title
    :type: string, required

    The name of the extension in English.

..  confval:: description
    :name: ext-emconf-description
    :type: string, required

    Short and precise description in English of what the extension does
    and for whom it might be useful.

..  confval:: version
    :name: ext-emconf-version
    :type: string

    Version of the extension. Automatically managed by extension manager /
    TER. Format is [int].[int].[int]

..  confval:: category
    :name: ext-emconf-category
    :type: string

    Which category the extension belongs to:

    `be`
          Backend (Generally backend-oriented, but not a module)
    `module`
          Backend modules (When something is a module or connects with one)
    `fe`
          Frontend (Generally frontend oriented, but not a "true" plugin)
    `plugin`
          Frontend plugins (Plugins inserted as a "Insert Plugin" content
          element)
    `misc`
          Miscellaneous stuff (Where not easily placed elsewhere)
    `services`
          Contains TYPO3 services
    `templates`
          Contains website templates
    `example`
          Example extension (Which serves as examples etc.)
    `doc`
          Documentation (e.g. tutorials, FAQ's etc.)
    `distribution`
          Distribution, an extension kick starting a full site

..  confval:: constraints
    :name: ext-emconf-constraints
    :type: array

    List of requirements, suggestions or conflicts with other extensions
    or TYPO3 or PHP version. Here is how a typical setup might look:

    ..  literalinclude:: _ExtEmconf/_ext_emconf_constraints.php
        :caption: packages/my_extension/ext_emconf.php

    depends
        List of extensions that this extension depends on.
        Extensions defined here will be loaded *before* the current extension.

    conflicts
         List of extensions which will not work with this extension.

    suggests
        List of suggestions of extensions that work together or
        enhance this extension.
        Extensions defined here will be loaded *before* the current extension.
        Dependencies take precedence over suggestions.
        Loading order especially matters when overriding TCA or SQL of another extension.

        The above example indicates that the extension depends on a
        version of TYPO3 between 11.4 and 12.4 (as only bug and security fixes are
        integrated into TYPO3 when the last digit of the version changes, it is
        safe to assume it will be compatible with any upcoming version of the
        corresponding branch, thus ``.99``). Also the extension has been
        tested and is known to work properly with PHP 8.1. to 8.3 It
        will conflict with "templavoilaplus" (any version) and it is suggested
        that it might be worth installing "news" (version at least 11.0.0).
        Be aware that you should add *at least* the TYPO3 and PHP version constraints
        to this file to make sure everything is working properly.

    For Classic mode installations, the :file:`ext_emconf.php` file
    is the source of truth for required dependencies and the loading order
    of active extensions.

    ..  note::
        Extension authors should ensure that the information here is in sync
        with the :file:`composer.json <extension-composer-json>` file.
        This is especially important regarding constraints like `depends`,
        `conflicts` and `suggests`. Use the equivalent settings as in
        :file:`composer.json <extension-composer-json>` `require`, `conflict` and `suggest` to set
        dependencies and ensure a specific loading order.

..  confval:: state
    :name: ext-emconf-state
    :type: string

    Which state is the extension in

    `alpha`
        Alpha state is used for very initial work, basically the extension is
        during the very process of creating its foundation.
    `beta`
        Under current development. Beta extensions are functional, but not
        complete in functionality.
    `stable`
        Stable extensions are complete, mature and ready for production
        environment. Authors of stable extensions carry a responsibility to
        maintain and improve them.
    `experimental`
        Experimental state is useful for anything experimental - of course.
        Nobody knows if this is going anywhere yet...  Maybe still just an
        idea.
    `test`
        Test extension, demonstrates concepts, etc.
    `obsolete`
        The extension is obsolete or deprecated. This can be due to other
        extensions solving the same problem but in a better way or if the
        extension is not being maintained anymore.
    `excludeFromUpdates`
        This state makes it impossible to update the
        extension through the Extension Manager (neither by the update
        mechanism, nor by uploading a newer version to the installation). This
        is very useful if you made local changes to an extension for a
        specific installation and do not want any administrator to overwrite
        them.

..  confval:: clearCacheOnLoad
    :name: ext-emconf-clearcacheonload
    :type: boolean
    :Default: false

    ..  deprecated:: 12.1
        When loading or unloading extensions using the extension manager,
        all caches are always cleared. Extensions that want to keep
        compatibility with both TYPO3 v11 and v12 should keep the setting
        until v11 compatibility is dropped from the extensions.

..  confval:: author
    :name: ext-emconf-author
    :type: string

    Author name

..  confval:: author_email
    :name: ext-emconf-author-email
    :type: email address

    Author email address

..  confval:: author_company
    :name: ext-emconf-author-company
    :type: string

    Author company


..  confval:: autoload
    :name: ext-emconf-autoload
    :type: array

    To get better class loading support for websites in Classic mode
    the following information can be provided.

    **Extensions using namespaces and following PSR 4**

    If the extension has namespaced classes following the PSR-4 standard, then you
    can add the following to your :file:`ext_emconf.php` file:

    ..  literalinclude:: _ExtEmconf/_ext_emconf_autoload_psr_4.php
        :caption: packages/my_extension/ext_emconf.php

    **Extensions having one folder with classes or single files**

    It is not recommended but possible to use different name space schemes
    or no namespace at all.

    Considering you have an extension where all classes
    and interfaces reside in a :file:`Classes` folder or single classes you can
    add the following to your :file:`ext_emconf.php` file:

    ..  literalinclude:: _ExtEmconf/_ext_emconf_autoload.php
        :caption: packages/my_extension/ext_emconf.php

..  confval:: autoload-dev
    :name: ext-emconf-autoload-dev
    :type: array

    Same as the configuration "autoload" but it is only used if the
    *ApplicationContext* is set to *Testing*.
