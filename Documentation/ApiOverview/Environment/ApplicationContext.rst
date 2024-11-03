:orphan:

..  include:: /Includes.rst.txt
..  index:: ! Application Context

..  _application-context:

===================
Application Context
===================

In previous TYPO3 versions, error messages were displayed unfiltered in the
frontend and often revealed security-relevant data such as database access,
e-mail addresses, SMTP access and similar to the public. The so-called
`ApplicationContext` was introduced to prevent this. These contexts can
pre-configure TYPO3 to a certain extent and can also be queried again at
various points such as the site configuration, e.g. to provoke a different
:ref:`base variants <sitehandling-baseVariants>`.

TYPO3 is delivered with 3 different modes, which affect the behaviour of TYPO3
as follows:

*   Production

    *   Only errors are logged.
    *   There is no logging of obsolete (deprecated) function calls.
    *   In the event of an error, the frontend only displays:
        `Oops, an error occurred! Code: {code}`.
    *   The :ref:`Dependency injection <Dependency-Injection>` cache can only
        be emptied using the Flush Cache button in the install tool.
    *   Calling up the install tool menu items requires the additional entry
        of a password.
    *   Only admins with system maintainer authorisation can see the
        install tool menu items in the TYPO3 backend.
    *   This mode offers the most performance and is most secure.

*   Development

    *   Errors and warnings are logged.
    *   Obsolete (deprecated) function calls are logged in an additional
        log file.
    *   The error appears in the frontend with a note on where and in which
        file it occurred.
    *   In the backend, the corresponding table field is also displayed in
        square brackets after each label when editing data records.
    *   The :guilabel:`Clear All Cache` button at the top right also clears
        the :ref:`Dependency injection <Dependency-Injection>` cache.
    *   The menu items in the backend for the install tool no longer require an
        additional password entry.
    *   Admins without system maintainer authorisation can also see the menu
        items for the install tool.

*   Testing

    *   In this special mode, caching
        for :ref:`Class Loading <composer-class-loader>` is switched off or is
        only valid for one request.

..  _default-application-context:

Default ApplicationContext
==========================

In the :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder`, TYPO3 reads
different environment variables to determine the desired `ApplicationContext`.
The following order applies from high priority to no priority:

*   Environment variable: :php:`TYPO3_CONTEXT`
*   Environment variable: :php:`REDIRECT_TYPO3_CONTEXT`
*   Environment variable: :php:`HTTP_TYPO3_CONTEXT`
*   `ApplicationContext` is set to `Production`

..  _set-application-context:

Set the ApplicationContext
==========================

The `ApplicationContext` is read very early in TYPO3. Even before the actual
TYPO3 bootstrap process. This means that even if you set the
`ApplicationContext` in `additional.php` (formerly
`AdditionalConfiguration.php`), it is already too late.

It is best to set the `ApplicationContext` as an environment variable in the
server configuration. Alternatively, you need a solution to set the environment
variable at PHP level before the actual TYPO3 call.

..  _set-application-context-apache:

Apache
------

In the vhost configuration as well as in the :file:`.htaccess`, the
`ApplicationContext` can be set as follows:

..  code-block:: bash
    :caption: `[web root]/.htaccess`

    SetEnv TYPO3_CONTEXT Development

..  attention::
    Some hosts may prevent the setting of environment variables using
    `.htaccess`. In this case, you will have to find another solution. Have a
    look at the following examples below.

..  _set-application-context-nginx:

Nginx
-----

..  code-block::
    :caption: /etc/nginx/nginx.conf

    fastcgi_param TYPO3_CONTEXT Development;

..  _set-application-context-env:

.env (Composer only)
--------------------

It is possible to import `.env` files into the root directory of your project.
All contained values are then made available as environment variables. The
basis for this is the Symfony `.env loader` :composer:`symfony/dotenv`. However,
this package requires a few method calls for initialisation. You can either
build this yourself or use the
`HelHum .env connector` :composer:`helhum/dotenv-connector`. This will
initialise the Symfony package for you.

Installation
~~~~~~~~~~~~

..  code-block::

    composer req helhum/dotenv-connector

.env
~~~~

Please make sure not to insert any spaces before and after the `=`

..  code-block:: bash
    :caption: `[web root]/.env`

    TYPO3_CONTEXT=Development/Dev1

..  _set-application-context-autoloader:

AutoLoader (Composer only)
--------------------------

If your TYPO3 was set up using Composer, you can misuse the
`Composer files <https://getcomposer.org/doc/04-schema.md#files>`__
property to load a specific file with each request before all other files.

..  tabs::

    ..  group-tab:: composer.json

        ..  code-block:: json

            {
                'autoload': {
                    'files': ['Source/Scripts/ApplicationContext.php']
                }
            }

    ..  group-tab:: ApplicationContext.php

        ..  code-block:: php

            <?php
            putenv('TYPO3_CONTEXT=Development');

..  _set-application-context-php-ini:

php.ini
-------

In `php.ini` there is the option of always loading a specific file first for
each request. The property is
`auto_prepend_file <https://www.php.net/manual/en/ini.core.php#ini.auto-prepend-file>`.
Enter the absolute path to a php file with the following content in your
hosting package.

..  code-block:: php

    <?php
    putenv('TYPO3_CONTEXT=Development');

..  attention::
    Some hosters do not offer the option of setting this value in their
    configuration menus. If the hoster uses Plesk, you can try to make this
    setting in a `user.ini` in the document root. Alternatively, try
    `.user.ini`, `php.ini` and also `.php.ini`. If in doubt, ask the hoster
    what alternative options are available.

..  _set-application-context-index-php:

index.php
---------

Please use this version as a last resort if none of the previous versions have
worked or if your hoster has restricted you enormously. This solution only
works for the frontend. This means that the `ApplicationContext` displayed in
the TYPO3 backend may differ from the `ApplicationContext` actually used in
the frontend.

Create your own `index.php` in the document root directory and then load the
actual `index.php` from there.

..  code-block:: php

    <?php
    putenv('TYPO3_CONTEXT=Development');
    require_once('typo3_src/index.php')

..  _sub-application-context:

Sub `ApplicationContext`
========================

The `ApplicationContext` can be subdivided further using `/`. Here are a
few examples:

*   Development/Dev1
*   Development/Local/Ddev
*   Testing/UnitTest
*   Production/1und1

You can use this subdivision to realise different acceptance domains for
customers. Using the option of composer files described above, you can create
a file to set the `ApplicationContext` individually depending on the
`HTTP_HOST`. In the site configuration, you can query the `ApplicationContext`
again and use it to set a different base URI using the
:ref:`base variants <sitehandling-baseVariants>`:

*   Development/Dev1 -> dev1.example.com
*   Development/Dev2 -> dev2.example.com
*   Development/Dev3 -> dev3.example.com
*   Development/Dev4 -> dev4.example.com
*   Development/Dev5 -> dev5.example.com

..  _root-application-context:

Root ApplicationContext
=======================

It doesn't matter whether you are working with just one `ApplicationContext`
or with an `ApplicationContext` divided several times by a slash (`/`). The
first part is always the root `ApplicationContext` and must always be either
`Production`, `Development` or `Testing`, otherwise the `isProduction`,
`isDevelopment` and `isTesting` methods will not work.

..  _parent-application-context:

Parent ApplicationContext
=========================

This section only applies if you have divided the `ApplicationContext` into
several sections using slashes (`/`). The entire remaining value after the
first slash is used to instantiate a new `ApplicationContext`. The so-called
parent `ApplicationContext`. Here you can see how the context is nested:

*   ApplicationContext: `Development/Local/Ddev/Dev2`

    *   Root ApplicationContext: `Development`
    *   Parent ApplicationContext: `Local/Ddev/Dev2`

        *   Root ApplicationContext: `Local`
        *   Parent ApplicationContext: `Ddev/Dev2`

            *   Root ApplicationContext: `Ddev`
            *   Parent ApplicationContext: `Dev2`

As written above the root `ApplicationContext` must always be one of the 3
values: `Production`, `Development` or `Testing`. With the 2nd nesting at the
latest, the root `ApplicationContext` here is now `Local` and with the 3rd
nesting `Ddev`. There is no way to query this `root ApplicationContext` in the
PHP class :php:`ApplicationContext`! You only have the option of using
`getParent()` to access the next parent `ApplicationContext` and using
:php:`(string)getParent()` to return the complete `ApplicationContext` as a
string. This means that `Local/Ddev/Dev2` is returned at level 2
and `Ddev/Dev2` at level 3.

..  _read-application-context:

Reading the ApplicationContext
==============================

TYPO3 itself already queries the `ApplicationContext` in various places, but
you can also react to the `ApplicationContext` in various places.

..  _read-application-context-php:

PHP
---

Here are a few examples of how to access the `ApplicationContext` with the
:php:`Environment` class:

..  code-block:: php

    <?php
    use TYPO3\CMS\Core\Core\Environment;
    class SunnyProducts
    {
        public function getDiscount(): int
        {
            if (Environment::getContext()->isDevelopment()) {
                return 20;
            }

            return 4;
        }
    }

..  _read-application-context-site-configuration:

Site Config
-----------

..  code-block:: php

    baseVariants:
    -
      base: 'https://dev-1.example.com/'
      condition: 'applicationContext == "Development/Dev1"'

..  _read-application-context-typoscript:

TypoScript
----------

..  code-block:: typoscript

    if {
       value.data = applicationcontext
       equals = Development/Dev1
    }

..  code-block:: typoscript

    [applicationContext == "Development/Dev1"]
    page.10.wrap = <div style="border: 3px red solid;">|</div>
    [END]

..  _application-context-presets:

Presets
=======

As mentioned at the beginning, the `ApplicationContext` affects certain TYPO3
settings. Let's take a closer look at the presets from
`EXT:install` :php:`Classes/Configuration/Context/*`:

*   LivePreset with priority 50
*   DebugPreset with priority 50
*   CustomPreset with priority 10

As you can see, the LivePreset and the DebugPreset have the same priority. So
which one wins? It depends on the `ApplicationContext` that is set. If the
`Production ApplicationContext` is set, then the LivePreset gets 20 points more
priority. If the `Development ApplicationContext` is set, then the DebugPreset
gets 20 more priority points.

In each of the 3 files you can see which TYPO3 configuration is to be
overwritten at runtime and how. To clarify: Setting the `ApplicationContext`
changes the TYPO3 configuration at runtime. It does not actively change the
`settings.php` or `additional.php`!

..  attention::
    You can set the presets manually in the install tool. However, this has no
    effect on the `ApplicationContext`. If you set the preset to Debug, then
    the configurations from DebugPreset.php are written to `settings.php`
    (formerly LocalConfiguration.php). In the TYPO3 system information, however,
    the `ApplicationContext` is still set to Production
    (unless otherwise set using an environment variable).
