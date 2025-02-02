..  include:: /Includes.rst.txt
..  index::
    File; EXT:{extkey}/composer.json
    Extension development; composer.json

..  _composer-json:
..  _files-composer-json:

===============
`composer.json`
===============

*-- required* in Composer-based installations

..  typo3:file:: composer.json
    :name: extenstion-composer-json
    :scope: extension
    :regex: /^(EXT:[^\/]+\/composer\.json|packages\/[^\/]+\/composer\.json)$/
    :shortDescription: This file is a tool for dependency management in PHP. It provides information about an extensions and its dependencies in Composer-based installations.

..  This regex matches: - EXT:some_extension/composer.json - EXT:gridelements/composer.json - packages/my_extension/composer.json - packages/news/composer.json
..  It does NOT match: - composer.json (at project root) - project_root/composer.json

..  contents::
    :local:


Introduction
============

`Composer <https://getcomposer.org/>`__ is a tool for dependency management in
PHP. It allows you to declare the libraries your extension depends on and it
will manage (install/update) them for you.

`Packagist <https://packagist.org/>`__ is the main Composer repository. It
aggregates public PHP packages installable with Composer. Composer packages
can be published by the package maintainers on Packagist to be installable in an
easy way via the :bash:`composer require` command.

..  attention::
    When a Composer package with the type `typo3-cms-extension` is published on
    Packagist, it may be made available in the
    `TYPO3 Extension Repository <https://extensions.typo3.org/>`__
    automatically. See
    `TYPO3 TER Packagist Integration <https://extensions.typo3.org/about-extension-repository/ter-packagist-integration>`__
    for more information.

About the composer.json file
============================

..  note::
    While the file :file:`composer.json` is currently not strictly required
    for an extension to function properly in legacy non-Composer installations
    it is recommended to keep it in any public extension that is published to
    `TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__.

Including a :file:`composer.json` is strongly recommended for a number of
reasons:

#.  The file :file:`composer.json` is required for documentation that should
    appear on `docs.typo3.org <https://docs.typo3.org/>`__.

    See :ref:`h2document:migrate` for more information on the necessary changes
    for rendering of extension documentation.

#.  Working with Composer in general is strongly recommended for TYPO3.

    If you are not using Composer for your projects yet, see
    :ref:`migratetocomposer` in the "Upgrade Guide".


..  _ext-composer-json-minimal:

Minimal composer.json
---------------------

This is a minimal :file:`composer.json` for a TYPO3 extension:

*   The vendor name is `MyVendor`.
*   The :ref:`extension key <extension-key>` is `my_extension`.

Subsequently:

*   The PHP namespace will be :php:`MyVendor\MyExtension`
*   The Composer package name will be `my-vendor/my-extension`

..  literalinclude:: _ComposerJson/_MinimalComposer.json
    :language: json
    :caption: EXT:my_extension/composer.json

* see `composer.json schema <https://getcomposer.org/doc/04-schema.md>`__ for
  general Composer information
* see :ref:`ext-composer-json-properties` below for TYPO3 specific hints

..  versionchanged:: 11.4
    The ordering of installed extensions and their dependencies are loaded from
    the :file:`composer.json` file, instead of :file:`ext_emconf.php` in
    Composer-based installations.

..  note::
    Extension authors should ensure that the information in the
    :file:`composer.json` file is in sync with the one in the extension's
    :ref:`ext_emconf.php <ext_emconf-php>` file. This is especially important
    regarding constraints like :php:`depends`, :php:`conflicts` and
    :php:`suggests`. Use the equivalent settings in :file:`composer.json`
    `require`, `conflict` and `suggest` to set dependencies and ensure a
    specific loading order.


..  _ext-composer-json-extended:

Extended composer.json
----------------------

..  seealso::
    Please see :ref:`testing-extensions` for
    further changes to :file:`composer.json` for testing extensions.

..  literalinclude:: _ComposerJson/_ExtendedComposer.json
    :language: json
    :caption: EXT:my_extension/composer.json


*   See `composer.json schema <https://getcomposer.org/doc/04-schema.md>`__ for
    general Composer information.
*   See :ref:`ext-composer-json-properties` below for TYPO3-specific hints.


..  _ext-composer-json-properties:

Properties
==========

name
----

(*required*)

The name has the format: `<my-vendor>/<dashed extension key>`. "Dashed extension
key" means that every underscore (`_`) has been changed to a dash (`-`).
You must be owner of the vendor name and should register it on
`Packagist <https://packagist.org/>`__. Typically, the name will correspond to
your namespaces used in the :file:`Classes/` folder, but with different
uppercase / lowercase spelling, for example: The PHP namespace
:php:`JohnDoe\SomeExtension` may be `johndoe/some-extension` in
:file:`composer.json`.

description
-----------

(*required*)

Description of your extension (1 line).

..  _ext-composer-json-property-type:

type
----

(*required*)

Use `typo3-cms-extension` for third-party extensions.
The :file:`Resources/Public/` folder will be symlinked into the
:ref:`_assets/ <directory-public-assets>` folder of your web root.

Additionally, `typo3-cms-framework` is available for system extensions.

See `typo3/cms-composer-installers <https://github.com/TYPO3/CmsComposerInstallers>`__
(required by `typo3/cms-core`).

license
-------

(*recommended*)

Has to be `GPL-2.0-only` or `GPL-2.0-or-later`.
See: https://typo3.org/project/licenses/.


require
-------

(*required*)

At least, you will need to require `typo3/cms-core` in the according version(s).
You should add other system extensions and third-party extensions, if your
extension depends on them.

In Composer-based installations the loading order of extensions and their
dependencies is derived from `require` and `suggest`.



suggest
-------

You should add other system extensions and third-party extensions, if your
extension has an optional dependency on them.

In Composer-based installations the loading order of extensions and their
dependencies is derived from `require` and `suggest`.


autoload
--------

(*required*)

The autoload section defines the namespace/path mapping for
`PSR-4 autoloading <https://www.php-fig.org/psr/psr-4/>`. In TYPO3 we follow
the convention that all classes (except test classes) are in the directory
:file:`Classes/`.


..  _ext-composer-json-property-extension-key:

extra.typo3/cms.extension-key
-----------------------------

(*required*)

Not providing this property will emit a deprecation notice and will fail in
future versions.

..  hint::
    The property `extension-key` means the **literal string** `extension-key`,
    not your actual extension key. The value on the right side should be your
    actual extension key.

Example for extension key `my_extension`:

..  literalinclude:: _ComposerJson/_ExtensionKey.json
    :language: json
    :caption: Excerpt of EXT:my_extension/composer.json


Properties no longer used
=========================

replace with ``typo3-ter`` vendor name
--------------------------------------

..  literalinclude:: _ComposerJson/_ReplaceTypo3Ter.json
    :language: json
    :caption: Excerpt of EXT:my_extension/composer.json

This was used previously as long as the TER Composer Repository was
relevant. Since the TER Composer Repository is deprecated, the `typo3-ter/*` entry
within `replace` is not required.

replace with ``"ext_key": "self.version"``
------------------------------------------

..  literalinclude:: _ComposerJson/_ReplaceExtKey.json
    :language: json
    :caption: Excerpt of EXT:my_extension/composer.json

This was used previously, but is not compatible with latest Composer
versions and will result in a warning using `composer validate` or
result in an error with Composer version 2.0+:

..  code-block:: text

    Deprecation warning: replace.ext_key is invalid, it should have a vendor name, a forward slash, and a package name.
    The vendor and package name can be words separated by -, . or _. The complete name should match
    "^[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9](([_.]?|-{0,2})[a-z0-9]+)*$".
    Make sure you fix this as Composer 2.0 will error.


See
`comment on helhum/composer.json <https://gist.github.com/helhum/0ffd82525c90f305b81a8285329eb4f8#gistcomment-3239391>`__
and `revisions on helhum/composer.json <https://gist.github.com/helhum/0ffd82525c90f305b81a8285329eb4f8/revisions>`__.

More Information
================

Not TYPO3-specific:

*   `About Packagist <https://packagist.org/about>`__
*   `composer.json schema <https://getcomposer.org/doc/04-schema.md>`__
*   `Composer Getting Started <https://getcomposer.org/doc/00-intro.md>`__

TYPO3-specific:

*   The :ref:`section on testing <testing-extensions>` (in this manual) contains
    further information about adding additional properties to
    :file:`composer.json` that are relevant for testing.
*   The Composer plugin (not extension)
    `typo3/cms-composer-installers <https://packagist.org/packages/typo3/cms-composer-installers>`__
    is responsible for TYPO3-specific Composer installation. Reading the README
    file and source code can be helpful to understand how it works.
