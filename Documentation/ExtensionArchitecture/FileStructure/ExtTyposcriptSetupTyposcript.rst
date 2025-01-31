..  include:: /Includes.rst.txt
..  index:: File; EXT:{extkey}/ext_typoscript_setup.typoscript
..  _ext_typoscript_setup_typoscript:

=================================
`ext_typoscript_setup.typoscript`
=================================

..  typo3:file:: ext_typoscript_setup.typoscript
    :scope: extension
    :regex: /^.*ext\_typoscript\_setup\.(typoscript|txt|ts)/
    :shortDescription: Preset TypoScript setup for sites without site sets

    Preset TypoScript setup. Will be included in the setup section of all
    TypoScript **records**. Takes no effect in sites using :ref:`Site sets <t3coreapi:site-sets>`.

..  attention::

    ..  versionchanged:: 13.1

    This file takes no effect in sites that use :ref:`Site sets <t3coreapi:site-sets>`.
    This file works for backward compability reasons only in installations that depend
    on TypoScript records only.

    Provide the TypoScript in your site set. TypoScript that has to be loaded globally
    can be loaded via :ref:`ExtensionManagementUtility::addTypoScript <t3tsref:extdev-always-load>`.
