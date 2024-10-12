:navigation-title: Driver middlewares
..  include:: /Includes.rst.txt
..  index::
    Database; Middleware
..  _database-middleware:

================================
Doctrine DBAL driver middlewares
================================

..  versionadded:: 12.3

..  contents::
    :local:

Introduction
============

Doctrine DBAL supports custom driver middlewares since version 3. These
middlewares act as a decorator around the actual `Driver` component.
Subsequently, the `Connection`, `Statement` and `Result` components can be
decorated as well. These middlewares must implement the
:php:`\Doctrine\DBAL\Driver\Middleware` interface.
A common use case would be a middleware to implement SQL logging capabilities.

For more information on driver middlewares, see the `Architecture chapter`_ of
the Doctrine DBAL documentation. Furthermore, look up the implementation of the
:t3src:`adminpanel/Classes/Log/DoctrineSqlLoggingMiddleware.php` in the
Admin Panel system extension as an example.

:ref:`Global driver middlewares <database-middleware-global>` and
:ref:`driver middlewares for a specific connection <database-middleware-specific>`
are combined for a connection. They are :ref:`sortable <database-middleware-sorting>`.

..  _Architecture chapter: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/architecture.html


..  _database-middleware-global:

Register a global driver middleware
===================================

..  versionadded:: 13.0

Global driver middlewares are applied to all
:ref:`configured connections <database-configuration>`.

Example:

..  literalinclude:: _ext_localconf_global.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php


Disable a global middleware for a specific connection
-----------------------------------------------------

Example:

..  literalinclude:: _ext_localconf_global_disable.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php


..  _database-middleware-specific:

Register a driver middleware for a specific connection
======================================================

..  versionadded:: 12.3

..  deprecated:: 13.0
    Using the simple :php:`'identifier' => MyClass::class'` configuration schema
    to register Doctrine DBAL middlewares for a connection is now deprecated in
    favour of using a
    :ref:`sortable registration configuration <database-middleware-sorting>`
    similar to the PSR-15 middleware registration.
    See :ref:`database-middleware-specific-migration`
    and :ref:`database-middleware-specific-registration-v12-v13`.

In this example, the custom driver middleware :php:`MyDriverMiddleware` is added
to the `Default` connection:

..  literalinclude:: _ext_localconf_specific.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php


..  _database-middleware-specific-migration:

Migration
---------

For example:

..  literalinclude:: _ext_localconf_specific_deprecated.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php

needs to be converted to:

..  literalinclude:: _ext_localconf_specific.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php

..  _database-middleware-specific-registration-v12-v13:

Registration for driver middlewares for TYPO3 v12 and v13
---------------------------------------------------------

Extension authors providing dual Core support in one extension version can use
the :php:`Typo3Version` class to provide the configuration suitable for the Core
version and avoiding the deprecation notice:

..  literalinclude:: _ext_localconf_specific_dual_versions.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php


..  _database-middleware-sorting:

Sorting of driver middlewares
=============================

..  versionadded:: 13.0

:ref:`Global driver middlewares <database-middleware-global>` and
:ref:`connection driver middlewares <database-middleware-specific>`
are combined for a connection.

TYPO3 makes the global and connection driver middlewares sortable
similar to the :ref:`PSR-15 middleware stack <request-handling>`. The available
structure for a middleware configuration is:

..  confval:: target

    :Data type: string
    :Required: yes

    The fully-qualified class name of the driver middleware.

..  confval:: before

    :Data type: list of strings
    :Required: no
    :Default: :php:`[]`

    A list of middleware identifiers the current middleware should be registered
    before.

..  confval:: after

    :Data type: list of strings
    :Required: no
    :Default: :php:`[]`

    A list of middleware identifiers the current middleware should be registered
    after.

    ..  note::
        All custom driver middlewares, global or connection-based, should be
        placed after the `'typo3/core/custom-platform-driver-middleware'` and
        `'typo3/core/custom-pdo-driver-result-middleware'` driver middlewares to
        ensure essential Core driver middlewares have been processed first.

..  confval:: disabled

    :Data type: boolean
    :Required: no
    :Default: :php:`false`

    It can be used to disable a global middleware for a specific connection.

    ..  warning::
        Do not disable global driver middlewares provided by TYPO3 - they are
        essential.

Example:

..  literalinclude:: _ext_localconf_sorting.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php

..  tip::
    If the :doc:`lowlevel system extension <ext_lowlevel:Index>` is installed
    and active, a :guilabel:`Doctrine DBAL Driver Middlewares` section is
    provided in the :guilabel:`System > Configuration` module to view the raw
    middleware configuration and the ordered middlewares for each connection:

    ..  figure:: /Images/ManualScreenshots/Database/MiddlewareConfigurationModule.png
        :alt: Example of the configuration of driver middlewares
        :class: with-shadow

        Example of the configuration of driver middlewares


..  _database-middleware-UsableForConnectionInterface:

The interface :php:`UsableForConnectionInterface`
=================================================

..  versionadded:: 13.0

..  note::
    Real use cases for this interface should be rare edge cases. Typically,
    a driver middleware should only be configured on a connection where it is
    needed - or does not harm, if used for all connection types as a global
    driver middleware.

Doctrine DBAL driver middlewares can be registered
:ref:`globally for all connections <database-middleware-global>` or for
:ref:`specific connections <database-middleware-specific>`. Due to the nature of
the decorator pattern, it may become hard to determine for a specific
configuration or drivers, if a middleware needs to be executed only for a
subset, for example, only specific drivers.

TYPO3 provides a custom :php:`\TYPO3\CMS\Core\Database\Middleware\UsableForConnectionInterface`
driver middleware interface which requires the implementation of the method
:php:`canBeUsedForConnection()`:

..  include:: /CodeSnippets/Manual/Database/UsableForConnectionInterface.rst.txt

This allows to decide, if a middleware should be used for a specific connection,
either based on the :php:`$connectionName` or the :php:`$connectionParams`,
for example the concrete :php:`$connectionParams['driver']`.

Example
-------

The custom driver:

..  literalinclude:: _CustomDriver.php
    :language: php
    :caption: EXT:my_extension/Classes/DoctrineDBAL/CustomDriver.php

The custom driver middleware which implements the
:php:`\TYPO3\CMS\Core\Database\Middleware\UsableForConnectionInterface`:

..  literalinclude:: _CustomMiddleware.php
    :language: php
    :caption: EXT:my_extension/Classes/DoctrineDBAL/CustomMiddleware.php

Register the custom driver middleware:

..  literalinclude:: _ext_localconf_CustomMiddleware.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php
