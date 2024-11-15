.. include:: /Includes.rst.txt
.. index:: File; EXT:{extkey}/ext_typoscript_constants.typoscript
.. _ext_typoscript_constants_typoscript:

===========================================
:file:`ext_typoscript_constants.typoscript`
===========================================

Preset TypoScript constants. Will be included in the constants section of all
TypoScript **records**. Takes no effect in sites using :ref:`Site sets <t3coreapi:site-sets>`.

..  attention::

    ..  versionchanged:: 13.1

    This file takes no effect in sites that use :ref:`Site sets <t3coreapi:site-sets>`
    This file works for backward compability reasons only in installations that depend
    on TypoScript records only.

    Provide settings in your :ref:`Site settings definitions <t3coreapi:site-settings-definition>` 
    in your site set. TypoScript constants that have to be loaded globally
    can be loaded via :ref:`ExtensionManagementUtility::addTypoScript <t3tsref:extdev-always-load>`.
