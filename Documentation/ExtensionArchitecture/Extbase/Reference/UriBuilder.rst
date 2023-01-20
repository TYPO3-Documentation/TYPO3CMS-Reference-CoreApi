.. include:: /Includes.rst.txt

.. index:: Extbase; URI builder
..  _uri-builder:

===========
URI builder
===========

The URI builder offers the possibility to create links in an Extbase context.


Usage in an Extbase controller
==============================

The URI builder is available as a property in a controller class which extends
the :ref:`extbase-action-controller` class.

Example:

..  literalinclude:: _UriBuilder/_MyController.php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

Have a look into the :ref:`API <uri-builder-api>` for the available methods of
the URI builder.

..  attention::
    As the URI builder holds state, you have to call :php:`reset()` before
    creating a URL.


Usage in another context
========================

The :php:`UriBuilder` class can be injection via constructor in a class:

..  literalinclude:: _UriBuilder/_MyClass.php
    :caption: EXT:my_extension/Classes/MyClass.php


..  _uri-builder-api:

API
===

..  include:: /CodeSnippets/Extbase/UriBuilder.rst.txt
