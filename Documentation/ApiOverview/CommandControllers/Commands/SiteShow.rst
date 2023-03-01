.. include:: /Includes.rst.txt

.. _symfony-console-commands-site-show:

===========================================
site:show (Show configuration for one site)
===========================================

The command needs an :ref:`identifier of a configured site
<sitehandling-basics-site-identifier>` which must be provided after the command
name. The command will output the complete configuration for the site in YAML
syntax.

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 site:show <identifier>

    ..  group-tab:: Legacy installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 site:show <identifier>


The command will output, for example:

..  code-block:: none

    Site configuration for main
    ===========================

    base: /
    languages:
        -
            title: English
            enabled: true
            languageId: 0
            base: /
            locale: en_GB.utf8
            navigationTitle: English
            flag: gb
            websiteTitle: ''
        -
            title: Deutsch
            enabled: true
            languageId: 1
            base: /de
            locale: de_DE.utf8
            navigationTitle: Deutsch
            flag: de
            websiteTitle: ''
            fallbackType: free
            fallbacks: ''
    rootPageId: 1
    websiteTitle: 'My site'
