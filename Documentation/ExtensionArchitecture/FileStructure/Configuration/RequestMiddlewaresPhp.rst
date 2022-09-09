.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/RequestMiddlewares.php
   Path; EXT:{extkey}/Configuration/RequestMiddlewares.php
.. _extension-configuration-RequestMiddlewares-php:


================================
:file:`RequestMiddlewares.php`
================================

Full path to this file is: :file:`Configuration/RequestMiddlewares.php`.

Configuration of user-defined middlewares for frontend and backend. Extensions
that add middlewares or disable existing middlewares configure them in this
file. The file must return an array with the configuration.

See :ref:`Configuring middlewares <request-handling-configuring-middlewares>`
for details.

.. include:: /CodeSnippets/Manual/Extension/Configuration/RequestMiddlewares.rst.txt
