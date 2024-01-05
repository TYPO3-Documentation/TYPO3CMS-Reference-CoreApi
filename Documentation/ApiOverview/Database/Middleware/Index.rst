..  include:: /Includes.rst.txt
..  index::
    Database; Middleware
..  _database-middleware:

===========
Middlewares
===========

..  versionadded:: 12.3

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

..  _Architecture chapter: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/architecture.html

..  contents::
    :local:


..  _database-middleware-specific:

Register a driver middleware for a specific connection
======================================================

In this example, the custom driver middleware :php:`MyMiddleware` is added
to the `Default` connection:

..  literalinclude:: _ext_localconf_specific.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php

They are applied after the :ref:`global driver middlewares <database-middleware-global>`.


..  _database-middleware-global:

Register a global driver middleware
===================================

..  versionadded:: 13.0

Global driver middlewares are applied to all
:ref:`configured connections <database-configuration>`.

First, the global driver middlewares are applied to all configured connections
and then the :ref:`specific connection middlewares <database-middleware-specific>`.

..  warning::
    Do not remove or disable global driver middlewares provided by TYPO3 - they
    are essential.

Example:

..  literalinclude:: _ext_localconf_global.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php


Disable a global middleware for a specific connection
-----------------------------------------------------

..  caution::
    It is possible to remove a global registered driver middleware for specific
    connections by setting the name to an empty string. Using :php:`unset()` on
    the global configuration array would remove it for all connections.

Example:

..  literalinclude:: _ext_localconf_global_disable.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | config/system/additional.php
