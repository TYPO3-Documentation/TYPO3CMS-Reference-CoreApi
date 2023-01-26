.. include:: /Includes.rst.txt

.. index:: Extbase; URI builder
..  _extbase-uri-builder:

=====================
URI builder (Extbase)
=====================

The URI builder offers a convenient way to create links in an Extbase context.


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

The :php:`\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder` class can be injected
via constructor in a class:

..  literalinclude:: _UriBuilder/_MyClass.php
    :caption: EXT:my_extension/Classes/MyClass.php


..  _uri-builder-api:

API
===

..  include:: /CodeSnippets/Extbase/UriBuilder.rst.txt
