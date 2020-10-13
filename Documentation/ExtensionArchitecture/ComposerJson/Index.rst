.. include:: /Includes.rst.txt


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

.. _ext-composer-json-minimal:

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
           "typo3-ter/my-extension": "self.version"
       },
       "autoload": {
           "psr-4": {
               "Vendorname\\MyExtension\\": "Classes/"
           }
       }
   }

* see `composer.json schema <https://getcomposer.org/doc/04-schema.md>`__ for
  general Composer information
* see :ref:`ext-composer-json-properties` below for TYPO3 specific hints

.. _ext-composer-json-extended:

Extended composer.json
======================

.. code-block:: json
   :linenos:

   {
       "name": "vendorname/my-extension",
       "type": "typo3-cms-extension",
       "description": "An example extension",
       "license": "GPL-2.0-or-later",
       "require": {
           "php" : "^7.2",
           "typo3/cms-backend": "^v8.7 || ^9.5 || ^10.4",
           "typo3/cms-core": "^v8.7 || ^9.5 || ^10.4"
       },
       "authors": [
          "name": "John Doe",
          "role": "Developer",
          "email": "john.doe@example.org",
          "homepage": "www.johndoe.example.org"
       ],
       "keywords": [
          "typo3",
          "blog"
       ],
       "support": {
          "issues": "https://github.com/vendorname/my-extensions/issues"
       },
       "funding": {
          "type": "other",
          "url:" : "myfundpage.org/vendorname"
       }
       "replace": {
           "typo3-ter/my-extension": "self.version"
       },
       "autoload": {
           "psr-4": {
               "Vendorname\\MyExtension\\": "Classes/"
           }
       },
       "require-dev": {
          "nimut/testing-framework": "^4.2 || ^5.1"
       }
   }

* see `composer.json schema <https://getcomposer.org/doc/04-schema.md>`__ for
  general Composer information
* see :ref:`ext-composer-json-properties` below for TYPO3 specific hints


.. _ext-composer-json-properties:

Properties
==========

name
----

(*required*)

`<vendorname>/<dashed extension key>` "Dashed extension key" means that every underscore (`_`) has been changed to a dash (`-`).
You must be owner of the vendor name and should register it on packagist.
Typically, the name will correspond to your namespaces used in the :file:`Classes` folder,
but with different uppercase / lowercase spelling,
e.g. `GeorgRinger\News` namespace and `georgringer/news` name in :file:`composer.json`.

description
-----------

(*required*)

Description of your extension (1 line)

type
----

(*required*)

Use `typo3-cms-extension` for third party extensions. This will result in
the extension to be installed in `{web-dir}/typo3conf/ext` instead
of `vendor/{vendor}/{package}`.

Use `typo3-cms-framework` for system extensions. They will be installed
in `web-dir/typo3/sysext`.

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

At the least, you will want to require `typo3/cms-core`.
You can add other system extensions and third party extensions,
if your extension depends on them.


autoload
--------

(*required*)

Define namespace - path mapping for PSR-4 autoloading.
In TYPO3 we follow the convention that all classes (except test classes)
are in the directory :file:`Classes`.

extra
-----

(*required*)

The extra `typo3/cms` section is used to provide a TYPO3 extension_key for the package.
If not provided, the package-key will be used with all dashes (`-`)
replaced by underscores (`_`) to follow TYPO3 and Packagist conventions.

Not providing this property will emit a deprecation notice and will fail in future versions.

So, the following section can be provided, but the default will result in
the same thing:

.. code-block:: json

   "extra": {
      "typo3/cms": {
         "extension-key": "my_extension"
      }
   },

replace
-------

(*usually not required*)

`replace <https://getcomposer.org/doc/04-schema.md#replace>`__ in a
:file:`composer.json` file specifies which other packages can be
replaced by this package. This means that packages with different
vendor name or package name will be treated as the same package by
Composer.

.. code-block:: json

   "replace": {
      "typo3-ter/my-extension": "self.version"
   }


As all extensions available in the TER can be installed
with `composer require typo3-ter/ext-key`, this makes sure that
there will be no conflicts with packages installed or required
via Packagist or from another source.

Since the TER Composer repository is deprecated and not all extensions
must be available in TER, this property is usually not required.

Properties no longer used
=========================

version
-------

Was used in earlier TYPO3 versions.
For TYPO3 versions 7.6 and above you should not use the version property.
The version for the extension is set in the file :ref:`ext_emconf.php <ext_emconf-php>`.

replace with ``"ext_key": "self.version"``
------------------------------------------

.. code-block:: json

   "replace": {
      "ext_key": "self.version"
   }

This was used previously, but is not compatible with latest Composer
versions and will result in a warning using `composer validate` or
result in an error with Composer version >=2.0:

.. code-block:: shell

   $ Deprecation warning: replace.ext_key is invalid, it should have a vendor name, a forward slash, and a package name.
     The vendor and package name can be words separated by -, . or _. The complete name should match
     "^[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9](([_.]?|-{0,2})[a-z0-9]+)*$".
     Make sure you fix this as Composer 2.0 will error.


See
`comment on helhum/composer.json <https://gist.github.com/helhum/0ffd82525c90f305b81a8285329eb4f8#gistcomment-3239391>`__
and `revisions on helhum/composer.json <https://gist.github.com/helhum/0ffd82525c90f305b81a8285329eb4f8/revisions>`__.

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
