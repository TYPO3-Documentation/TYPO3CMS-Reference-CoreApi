.. include:: ../../Includes.txt

.. _bootstrapping:

=============
Bootstrapping
=============

TYPO3 CMS has a clean bootstrapping process driven mostly
by class :php:`\TYPO3\CMS\Core\Core\Bootstrap`. This class
contains a host of methods each responsible for a little
step along the initialization of a full TYPO3 process,
be it the backend or other contexts.

Some contexts add their own bootstrap class (like the command
line, which additionally requires :php:`\TYPO3\CMS\Core\Core\CliBootstrap`).

.. note::

   The frontend's bootstrapping process is not yet fully encapsulated
   in a bootstrap class.

.. warning::

   This bootstrapping API is internal and may change at any time in the near future
   even in minor updates. It is thus discouraged to use it in third party code.
   Use this class only if other extensibility possibilities such as
   :ref:`Hooks <hooks>`, Signals or :ref:`XCLASS <xclasses>`
   are not enough to reach your goals.


One can see the bootstrapping process in action in file
:file:`typo3/sysext/backend/Classes/Http/Application.php`::

   use TYPO3\CMS\Core\Core\Bootstrap;

   ###

   $this->bootstrap = Bootstrap::getInstance()
      ->initializeClassLoader($classLoader)
      ->setRequestType(TYPO3_REQUESTTYPE_BE | (!empty($_GET['ajaxID']) ? TYPO3_REQUESTTYPE_AJAX : 0))
      ->baseSetup($this->entryPointLevel);

   // Redirect to Install Tool if base configuration is not found
   if (!$this->bootstrap->checkIfEssentialConfigurationExists()) {
      $this->bootstrap->redirectToInstallTool($this->entryPointLevel);
   }

   foreach ($this->availableRequestHandlers as $requestHandler) {
      $this->bootstrap->registerRequestHandlerImplementation($requestHandler);
   }

   $this->bootstrap->configure();

   ###


Note that most methods of the Bootstrap class must be called in a precise order.
It is perfectly possible to define one's own bootstrapping process, but care
should be taken about the call order.

Also note that all bootstrapping methods return the instance of the
Bootstrap class itself, allowing calls to be chained.


.. _backend-initialization:

Initialization
==============

Whenever a call to TYPO3 CMS is made, the application goes through a
bootstrapping process managed by a dedicated API. This process is also
used in the frontend, but only the backend process is described here.

.. note::
   This chapter is outdated and should probably be merged with the "HTTP request library / Guzzle / PSR-7"
   chapter below. The chapter should include an overview of single bootstrap steps, PSR-15 and routing.

Classes involved in the backend bootstrapping process are :php:`\TYPO3\CMS\Core\Core\Bootstrap` and :php:`TYPO3\CMS\Backend\Http\Application`.

The following steps are performed during bootstrapping.

1. Define Legacy Constants
""""""""""""""""""""""""""

In :php:`Application::defineLegacyConstants` some constants are defined, which will eventually
be dropped, but are still initialized for now.

2. Initialize Class Loader
--------------------------

This defines which autoloader to use.

3.  Set Request Type
--------------------

The request type is set - this defines whether the current request is a frontend, backend, cli, ajax or Install Tool
request. (see `defineTypo3RequestTypes`).

4. Perform base setup
---------------------

An instance of :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder` is
created. This class in turn defines a large number of constants and global
variables. If you want to have an overview of these base values, it is
worth taking a look into the following methods:

-  :php:`SystemEnvironmentBuilder::defineBaseConstants()` defines
   constants containing values such as the current version number,
   blank character codes and error codes related to services.

-  :php:`SystemEnvironmentBuilder::definePaths()` defines constants
   containing paths to various parts of the TYPO3 installation like
   the absolute path to the :file:`typo3` directory or the absolute
   path to the installation root.

-  :php:`SystemEnvironmentBuilder::checkMainPathsExist()` checks if
   expected paths like :file:`typo3` or :file:`index.php` exist. If that
   is not the case, the process will quit immediately.

-  :php:`SystemEnvironmentBuilder::initializeGlobalVariables()` sets
   some global variables as empty arrays.

-  :php:`SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
   defines special variables which contain, for example, the current time or
   a simulated time as may be set using the Admin Panel.

-  :php:`SystemEnvironmentBuilder::initializeBasicErrorReporting()`
   sets up default error reporting level during the bootstrapping process.

5. Define Class Loading Information
-----------------------------------

This part of the bootstrap processes all the information available to be able to
determine where to load classes from, including class alias maps which
are used to map legacy class names to new class names.

6. Check Essential Configuration
--------------------------------

In this step we check if crucial configuration elements have been set.
If that is not the case, the installation is deemed incomplete and the
user is redirected to the Install Tool.

7. Register Request Handlers
----------------------------

The backend recognizes various request handlers, one to handle general requests,
one for backend module requests, one for cli requests and one for AJAX requests.

8. More Configuration
---------------------

Next :php:`Bootstrap::configure()` is called which in turn triggers
a whole new series of configuration. This is actually a major step,
with too many actions to detail efficiently here. However here is the
list of the most important stuff happening at this point:

-  the main configuration ("TYPO3_CONF_VARS") is loaded

-  the Caching Framework and the Package Management are set up

-  all configuration items from extensions are loaded

-  the database connection is established

9. Dispatch
-----------

After all that the :php:`Application::run()` method is called, which
basically dispatches the request to the right handler.

10. Initialization of the TYPO3 Backend
---------------------------------------

The backend request handler has its own :php:`boot()` method, which performs
yet more initialization and set up as needed. A general request to the
backend will typically go through such important steps like:

-  checking backend access: Is it locked? Does it have proper SSL setup?

-  loading the full :ref:`TCA <t3tca:start>`

-  verifying and initializing the backend user


.. _bootstrapping-context:
.. _application-context:

Application Context
===================

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

   # In your Apache configuration, you usually use:
   SetEnv TYPO3_CONTEXT Development

   # Set context with mod_rewrite
   # Rules to set ApplicationContext based on hostname
   RewriteCond %{HTTP_HOST} ^dev\.example\.com$
   RewriteRule .? - [E=TYPO3_CONTEXT:Development]

   RewriteCond %{HTTP_HOST} ^staging\.example\.com$
   RewriteRule .? - [E=TYPO3_CONTEXT:Production/Staging]

   RewriteCond %{HTTP_HOST} ^www\.example\.com$
   RewriteRule .? - [E=TYPO3_CONTEXT:Production]


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
-------------

The current Application Context is set very early in the bootstrap process and can be accessed
through public API for example in the :file:`AdditionalConfiguration.php` file to automatically set
different configuration for different contexts.

In file :file:`typo3conf/AdditionalConfiguration.php`:

.. code-block:: php

   switch (\TYPO3\CMS\Core\Core\Environment::getContext()) {
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
