.. include:: /Includes.rst.txt
.. index:: Link builder
.. _link-builder:

=====================
Frontend link builder
=====================

A link builder, a class extending the abstract class
:php:`\TYPO3\CMS\Frontend\Typolink\AbstractTypolinkBuilder`, is called whenever
a link is rendered in the frontend.

There are specific link builders for each type of link. Which link to
call is determined by the class configured in global configuration,
see :ref:`typo3ConfVars_fe_typolinkBuilder`.

You can register a custom link builder in your extension's
:ref:`ext-localconf-php`:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']['mylinkkey'] =
        \MyVendor\MyExtension\LinkHandler\MyLinkBuilder::class;

The link builders provided by the Core can be found in namespace
:php:`\TYPO3\CMS\Frontend\Typolink`. It is possible to also create a
:ref:`custom link builder <tutorial-typolink-builder>`.

..  todo: Add link to the linkfactory for TYPO3 v12, add information on
    how the link builders are used in v11

The main method of a link builder is the function
:php:`AbstractTypolinkBuilder::build()`. It is called with
with the parameter array provided by the
:ref:`Core link handler <core-link-handler>`.

If the link can be rendered,
it returns a new :ref:`link result <link-result>`. The
actual rendering of the link depends on the context the link is rendered in
(for example HTML or JSON).

If the link cannot be built it should throw a
:php:`\TYPO3\CMS\Frontend\Typolink\UnableToLinkException`.
