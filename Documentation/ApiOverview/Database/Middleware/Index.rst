..  include:: /Includes.rst.txt
..  index::
    Database; Middleware
..  _database-middleware:

==========
Middleware
==========

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
adminpanel system extension as an example.

..  _Architecture chapter: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/architecture.html

Registering a new driver middleware
===================================

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['driverMiddlewares']['myextension_mymiddleware']
        = \MyVendor\MyExtension\Database\Log\MyMiddleware::class;
