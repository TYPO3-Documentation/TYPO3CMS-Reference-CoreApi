..  include:: /Includes.rst.txt
..  index:: Link builder
..  _link-builder:

=====================
Frontend link builder
=====================

..  deprecated:: 14.0
    The :php:`build()` method in :php:`TYPO3\CMS\Frontend\Typolink\AbstractTypolinkBuilder`
    has been deprecated in favor of the new
    :php:`\TYPO3\CMS\Frontend\Typolink\TypolinkBuilderInterface`.

    See also `Deprecation: #106405 - AbstractTypolinkBuilder->build <https://docs.typo3.org/permalink/changelog:deprecation-106405-1742674605>`_.

A link builder is a class that implements
:php:`\TYPO3\CMS\Frontend\Typolink\TypolinkBuilderInterface` and that is called when
a link is rendered in the frontend.

There are link builders for every type of link. Which link to
call is determined by the respective class configured in global configuration,
see :ref:`typo3ConfVars_fe_typolinkBuilder`.

Register a custom link builder in your extension's
:ref:`ext-localconf-php`:

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

The link builders provided by the Core can be found in namespace
:php:`\TYPO3\CMS\Frontend\Typolink`. It is possible to also create a
:ref:`custom link builder <tutorial-typolink-builder>`.

..  todo: Add link to the linkfactory for TYPO3 v12, add information on
    how the link builders are used in v11

The main method of a link builder is the function
:php:`TypolinkBuilderInterface::buildLink()`. It is called with
with the parameter array provided by the
:ref:`Core link handler <core-link-handler>`.

If the link can be rendered,
it returns a new :php:`\TYPO3\CMS\Frontend\Typolink\LinkResult` object. The
actual rendering of the link depends on the context the link is rendered in
(for example HTML or JSON).

If the link cannot be built it should throw a
:php:`\TYPO3\CMS\Frontend\Typolink\UnableToLinkException`.
