.. include:: ../../Includes.txt


.. _bootstrapping:

Bootstrapping
-------------

TYPO3 CMS has a clean bootstrapping process driven mostly
by class :code:`\TYPO3\CMS\Core\Core\Bootstrap`. This class
contains a host of methods each responsible for a little
step along the initialization of a full TYPO3 process,
be it the backend or other contexts.

Some contexts add their own bootstrap class (like the command
line, which additionally requires :code:`\TYPO3\CMS\Core\Core\CliBootstrap`.

.. note::

   The frontend's bootstrapping process is not yet fully encapsulated
   in a bootstrap class.

.. warning::

   This boostrapping API is internal and may change any time in the near future
   even in minor updates. It is thus discouraged to use it in third party code.
   Choose this solution only if other extensbility features such as
   :ref:`Hooks <hooks>`, Signals or :ref:`XCLASS <xclasses>`
   are not enough to reach your goals.


One can see the bootstrapping process in action in file

:file:`typo3/init.php`::

   define('TYPO3_MODE', 'BE');

   require 'sysext/core/Classes/Core/Bootstrap.php';

   \TYPO3\CMS\Core\Core\Bootstrap::getInstance()
      ->baseSetup('typo3/')
      ->redirectToInstallToolIfLocalConfigurationFileDoesNotExist('../')
      ->startOutputBuffering()
      ->loadConfigurationAndInitialize()
      ->loadTypo3LoadedExtAndExtLocalconf(TRUE)
      ->applyAdditionalConfigurationSettings()
      ->initializeTypo3DbGlobal()
      ->checkLockedBackendAndRedirectOrDie()
      ->checkBackendIpOrDie()
      ->checkSslBackendAndRedirectIfNeeded()
      ->checkValidBrowserOrDie()
      ->loadExtensionTables(TRUE)
      ->initializeSpriteManager()
      ->initializeBackendUser()
      ->initializeBackendUserMounts()
      ->initializeLanguageObject()
      ->initializeModuleMenuObject()
      ->initializeBackendTemplate()
      ->endOutputBufferingAndCleanPreviousOutput()
      ->initializeOutputCompression();


Note that most methods of the Bootstrap class must be called in a precise order.
It is perfectly possible to define one's own bootstrapping process, but care
should be taken about the call order.

Also note that all bootstrapping methods return the instance of the
Bootstrap class itself, allowing calls to be chained.


.. _bootstrapping-context:

Application Context
^^^^^^^^^^^^^^^^^^^

Each request, no matter if it runs from the command line or through HTTP,
runs in a specific *application context*. TYPO3 CMS provides exactly three built-in
contexts:

* ``Production`` (default) - should be used for a live site
* ``Development`` - used for development
* ``Testing`` - is only used internally when executing TYPO3 **core** tests. It must not be used otherwise.

The context TYPO3 runs in is specified through the environment variable
``TYPO3_CONTEXT``. It can be set on the command line:

.. code-block:: bash

   # run the TYPO3 CMS CLI commands in development context
   TYPO3_CONTEXT=Development ./typo3/cli_dispatch.phpsh


or be part of the web server configuration:

.. code-block:: apacheconf

   # In your Apache configuration (either .htaccess or vhost)
   # you can either set context to static value with:
   SetEnv TYPO3_CONTEXT Development

   # Or set context depending on current host header
   # using mod_rewrite module
   RewriteCond %{HTTP_HOST} ^dev\.example\.com$
   RewriteRule .? - [E=TYPO3_CONTEXT:Development]

   RewriteCond %{HTTP_HOST} ^staging\.example\.com$
   RewriteRule .? - [E=TYPO3_CONTEXT:Production/Staging]

   RewriteCond %{HTTP_HOST} ^www\.example\.com$
   RewriteRule .? - [E=TYPO3_CONTEXT:Production]

   # or using setenvif module
   SetEnvIf Host "^dev\.example\.com$" TYPO3_CONTEXT=Development
   SetEnvIf Host "^staging\.example\.com$" TYPO3_CONTEXT=Production/Staging
   SetEnvIf Host "^www\.example\.com$" TYPO3_CONTEXT=Production


.. code-block:: nginx

   # In your Nginx configuration, you can pass the context as a fastcgi parameter
   location ~ \.php$ {
      include         fastcgi_params;
      fastcgi_index   index.php;
      fastcgi_param   TYPO3_CONTEXT  Development/Dev;
      fastcgi_param   SCRIPT_FILENAME  $document_root$fastcgi_script_name;
   }


.. _bootstrapping-context-custom:

Custom Contexts
"""""""""""""""

In certain situations, more specific contexts are desirable:

* a staging system may run in a *Production* context, but requires a different set of
  credentials than the production server.
* developers working on a project may need different application specific settings
  but prefer to maintain all configuration files in a common Git repository.

By defining custom contexts which inherit from one of the three base contexts,
more specific configuration sets can be realized.

While it is not possible to add new "top-level" contexts at the same level like
*Production* and *Testing*, you can create arbitrary *sub-contexts*, just by
specifying them like ``<MainContext>/<SubContext>``.

For a staging environment a custom context ``Production/Staging`` may provide the
necessary settings while the ``Production/Live`` context is used on the live instance.

.. note::

   This even works recursively, so if you have a multiple-server staging
   setup, you could use the context ``Production/Staging/Server1`` and
   ``Production/Staging/Server2`` if both staging servers needed different
   configuration.

.. attention::

   ``Testing`` Is reserved for internal use when executing TYPO3 **core** functional and unit tests
   It must not be used otherwise. Instead sub-contexts must be used:
   ``Production/Testing`` or ``Development/Testing``


.. _bootstrapping-context-example:

Usage Example
"""""""""""""

The current Application Context is set very early in the bootstrap process can be accessed
through public API for example in the AdditionalConfiguration.php file to automatically set
different configuration for different contexts.

In file :file:`typo3conf/AdditionalConfiguration.php`:

.. code-block:: php

   switch (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()) {
      case 'Development':
         $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 1;
         $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '*';
         break;
      case 'Production/Staging':
         $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 0;
         $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '192.168.1.*';
         break;
      default:
         $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 0;
         $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '127.0.0.1';
   }
