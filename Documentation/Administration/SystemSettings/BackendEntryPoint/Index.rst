..  include:: /Includes.rst.txt

..  _backend-entry-point:

===================
Backend entry point
===================

..  youtube:: hsrAtnI9244

----

..  versionadded:: 13.0
    Before TYPO3 v13 the backend entry point path for accessing the backend has
    always been :samp:`/typo3`. Since TYPO3 v13 the backend entry point can be
    adjusted to something else. See :ref:`backend-entry-point-configuration`
    and :ref:`backend-entry-point-migration`.

    The legacy entry point :samp:`/typo3/index.php` is no longer needed and
    therefore deprecated. See :ref:`backend-entry-point-legacy-free`.

The TYPO3 backend URL is configurable in order to enable optional protection
against application administrator interface infrastructure enumeration
(`WSTG-CONF-05`_). Both frontend and backend requests are handled by the PHP
script :samp:`/index.php` to enable virtual administrator interface URLs.

The default TYPO3 backend entry point path :samp:`/typo3` can be changed by
specifying a custom URL path or domain name in
:ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['entryPoint'] <typo3ConfVars_be_entryPoint>`.

Adjusting the backend entry point does not take assets into account, only
routing is adapted. That means Composer mode will use assets provided via
:samp:`_assets/` as before and TYPO3 Classic mode will serve backend assets from
:samp:`/typo3/*` even if another backend URL is used and configured.

..  note::
    The install tool is still available via :samp:`/typo3/install.php`.

..  _WSTG-CONF-05: https://owasp.org/www-project-web-security-testing-guide/v42/4-Web_Application_Security_Testing/02-Configuration_and_Deployment_Management_Testing/05-Enumerate_Infrastructure_and_Application_Admin_Interfaces


..  _backend-entry-point-configuration:

Configuration
=============

The configuration can be done in the backend via
:guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`:

..  figure:: /Images/ManualScreenshots/AdminTools/ConfigureEntryPoint.png
    :alt: Configure the entry point via GUI
    :class: with-shadow

    Configure the entry point via GUI

or manually in :ref:`config/system/settings.php <typo3ConfVars-settings>` or
:ref:`config/system/additional.php <typo3ConfVars-additional>`.

..  _backend-entry-point-specific-path:

Configure a specific path
-------------------------

..  code-block:: php
    :caption: config/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['entryPoint'] = '/my-specific-path';

Now point your browser to :samp:`https://example.org/my-specific-path` to
log into the TYPO3 backend.


..  _backend-entry-point-specific-subdomain:

Use a distinct subdomain
------------------------

..  code-block:: php
    :caption: config/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['entryPoint'] = 'https://my-backend-subdomain.example.org';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain'] = '.example.org';

Now point your browser to `https://my-backend-subdomain.example.org/` to log
into the TYPO3 backend.

Note that the :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain']` is
necessary, so that backend users can preview website pages or use the admin
panel.

..  _backend-entry-point-legacy-free:

Legacy-free installation
------------------------

The legacy entry point `/typo3/index.php` is no longer needed and deprecated in
favor of handling all backend and frontend requests with :samp:`/index.php`. The
entry point is still in place in case webserver configuration has not been
adapted yet and the maintenance and emergency tool is still available via
:samp:`/typo3/install.php` in order to work in edge cases like broken web server
routing.

In Composer mode, an additional configuration option for the deactivation of
the legacy entry point is provided, which can be defined in the project's
:file:`composer.json`.

..  code-block:: json
    :caption: /path/to/project/composer.json (Excerpt)

    {
        "extra": {
            "typo3/cms": {
                "install-deprecated-typo3-index-php": false
            }
        }
    }

..  _backend-entry-point-migration:

Migration
=========

A silent update is in place which automatically updates the webserver
configuration file when accessing the install tool, at least for Apache
(:file:`.htaccess`) and Microsoft IIS (:file:`web.config`) webservers.

..  attention::
    The silent update does not work, if you are not using the default
    configuration, which is shipped with Core and automatically applied during
    the TYPO3 installation process, as basis.

If you use a custom web server configuration you may adapt as follows.


..  _backend-entry-point-migration-apache:

Apache configuration
--------------------

It is most important to rewrite all `typo3/*` requests to `/index.php`, but also
`RewriteCond %{REQUEST_FILENAME} !-d` should be removed in order for a request
to `/typo3/` to be directly served via `/index.php` instead of the deprecated
entry point `/typo3/index.php`.

Apache configuration before:

..  code-block:: apache
    :emphasize-lines: 2-4

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-l
    RewriteRule ^typo3/(.*)$ %{ENV:CWD}typo3/index.php [QSA,L]

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-l
    RewriteRule ^.*$ %{ENV:CWD}index.php [QSA,L]

Apache configuration after:

..  code-block:: apache
    :emphasize-lines: 2

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^typo3/(.*)$ %{ENV:CWD}index.php [QSA,L]

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-l
    RewriteRule ^.*$ %{ENV:CWD}index.php [QSA,L]

..  _backend-entry-point-migration-nginx:

NGINX configuration
-------------------

NGINX configuration before:

.. code-block:: nginx
   :emphasize-lines: 3

    location /typo3/ {
        absolute_redirect off;
        try_files $uri /typo3/index.php$is_args$args;
    }

NGINX configuration after:

.. code-block:: nginx
   :emphasize-lines: 3

    location /typo3/ {
        absolute_redirect off;
        try_files $uri /index.php$is_args$args;
    }
