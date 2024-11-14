.. include:: /Includes.rst.txt
.. index:: ! Bootstrapping
.. _bootstrapping:

=============
Bootstrapping
=============

TYPO3 has a clean bootstrapping process driven mostly
by class :php:`\TYPO3\CMS\Core\Core\Bootstrap`. This class is initialized by
calling  :php:`Bootstrap::init()` and serves as an entry point for later calling
an application class, depending on several context-dependant constraints.

Each application class registers request handlers to
run a certain request type (e.g. eID or Ajax requests in the backend). Each
application is handed over the class loader provided by Composer.

Applications
============

There are four types of applications provided by the TYPO3 Core:


\\TYPO3\\CMS\\Frontend\\Http\\Application
-----------------------------------------

This class handles all incoming web requests coming through :file:`index.php`
in the public web directory. It handles all regular page and eID requests.

It checks if all configuration is set, otherwise redirects to the TYPO3 Install
Tool.


\\TYPO3\\CMS\\Backend\\Http\\Application
----------------------------------------

This class handles all incoming web requests for any regular backend call
inside :file:`typo3/\*`.

Its :php:`TYPO3\CMS\Backend\Http\RequestHandler` is used for all backend
requests, including Ajax routes. If a get/post parameter "route" is set, the
backend routing is called by the :php:`RequestHandler` and
searches for a matching route inside the router. The corresponding controller
/ action is called then which returns the response.

The :php:`Application` checks if all configuration is set, otherwise it
redirects to the TYPO3 Install Tool.


\\TYPO3\\CMS\\Core\\Console\\CommandApplication
-----------------------------------------------

This class is the entry point for the TYPO3 command line for console commands.
In addition to registering all available commands, this also sets up a CLI user.


\\TYPO3\\CMS\\Install\\Http\\Application
----------------------------------------

The install tool :php:`Application` only runs with a very limited bootstrap
set up. The failsafe package manager does not take
the :php:`ext_localconf.php` of installed extensions into account.

.. warning::

   This bootstrapping API is internal and may change at any time in the near future
   even in minor updates. It is thus discouraged to use it in third party code.
   Use this class only if other extensibility possibilities such as
   :ref:`Events <eventdispatcher>`, :ref:`Hooks <hooks>`, or :ref:`XCLASS <xclasses>`
   are not enough to reach your goals.

Example of bootstrapping the TYPO3 Backend:

.. code-block:: php

   // Set up the application for the backend
   call_user_func(function () {
       $classLoader = require dirname(__DIR__) . '/vendor/autoload.php';
       \TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::run(1, \TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::REQUESTTYPE_BE);
       \TYPO3\CMS\Core\Core\Bootstrap::init($classLoader)->get(\TYPO3\CMS\Backend\Http\Application::class)->run();
   });


.. _backend-initialization:

Initialization
==============

Whenever a call to TYPO3 is made, the application goes through a
bootstrapping process managed by a dedicated API. This process is also
used in the frontend, but only the backend process is described here.

.. note::
   This chapter is outdated and should probably be merged with the "HTTP request library / Guzzle / PSR-7"
   chapter below. The chapter should include an overview of single bootstrap steps, PSR-15 and routing.

The following steps are performed during bootstrapping.

1. Initialize the class loader
------------------------------

This defines which autoloader to use.

2. Run SystemEnvironmentBuilder
-------------------------------

The :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder` is responsible for setting
up a system environment that is shared by all contexts (FE, BE, Install Tool and CLI).
This class defines a large number of constants and global variables. If you want
to have an overview of these base values, it is worth taking a look into the following methods:

-  :php:`SystemEnvironmentBuilder::defineTypo3RequestTypes()` defines the different
   constants for determining if the current request is a frontend, backend, CLI,
   Ajax or Install Tool request.

-  :php:`SystemEnvironmentBuilder::defineBaseConstants()` defines
   constants containing values such as the current version number,
   blank character codes and error codes related to services.

-  :php:`SystemEnvironmentBuilder::initializeEnvironment()` initializes the
   :php:`Environment` class that points to various parts of the TYPO3 installation like
   the absolute path to the :file:`typo3` directory or the absolute
   path to the installation root.

-  :php:`SystemEnvironmentBuilder::calculateScriptPath()` calculates the script
   path. This is the absolute path to the entry script. This can be something
   like '.../public/index.php' for web calls,
   or '.../bin/typo3' or similar for CLI calls.

-  :php:`SystemEnvironmentBuilder::initializeGlobalVariables()` sets
   some global variables as empty arrays.

-  :php:`SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
   defines special variables which contain, for example, the current time or
   a simulated time as may be set using the Admin Panel.

3.  Initialize bootstrap
------------------------

:php:`\TYPO3\CMS\Core\Core\Bootstrap` boots up TYPO3 and returns a container
that is later used to run an application. As a basic overview it does the
following:

-  :php:`Bootstrap::initializeClassLoader()` processes all the information
   available to be able to determine where to load classes from, including class
   alias maps which are used to map legacy class names to new class names.

-  :php:`Bootstrap::checkIfEssentialConfigurationExists()` checks if crucial
   configuration elements have been set. If that is not the case, the
   installation is deemed incomplete and the user is redirected to the Install Tool.

-  :php:`Bootstrap::createConfigurationManager()` creates the Configuration
   Manager which is then populated with the the main configuration ("TYPO3_CONF_VARS").

-  :php:`$builder->createDependencyInjectionContainer()` creates a :ref:`dependency
   injection <dependency-injection>` container which is later returned by :php:`Bootstrap::init()`.

-  The caching framework and the package management are set up.

-  All configuration items from extensions are loaded

-  The database connection is established

4. Dispatch
-----------

After all that the, the newly created container receives the application object
and :php:`Application::run()` method is called, which basically dispatches the
request to the right handler.


5. Initialization of the TYPO3 backend
--------------------------------------

The backend request handler then calls the :php:`MiddlewareDispatcher` which
then manages and dispatches a PSR-15 middleware stack. In the backend context
this will typically go through such important steps like:

-  checking backend access: Is it locked? Does it have proper SSL setup?

-  loading the full :ref:`TCA <t3tca:start>`

-  verifying and initializing the backend user

.. note::

   For more information on the middleware stack, you can continue reading the
   chapter :ref:`request-handling`.

.. _bootstrapping-context:

Application context
===================

Each request, no matter if it runs from the command line or through HTTP,
runs in a specific *application context*. TYPO3 provides exactly three built-in
contexts:

* ``Production`` (default) - should be used for a live site
* ``Development`` - used for development
* ``Testing`` - is only used internally when executing TYPO3 **Core** tests. It must not be used otherwise.

The context TYPO3 runs in is specified through the environment variable
``TYPO3_CONTEXT``. It can be set on the command line:

.. code-block:: bash

   # run the TYPO3 CLI commands in development context
   TYPO3_CONTEXT=Development ./bin/typo3


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

Custom contexts
---------------

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

   ``Testing`` Is reserved for internal use when executing TYPO3 **Core** functional and unit tests
   It must not be used otherwise. Instead sub-contexts must be used:
   ``Production/Testing`` or ``Development/Testing``


.. _bootstrapping-context-example:

Usage example
~~~~~~~~~~~~~

The current Application Context is set very early in the bootstrap process and can be accessed
through public API for example in the :file:`config/system/additional.php` file to automatically set
different configuration for different contexts.

In file :file:`config/system/additional.php`:

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
