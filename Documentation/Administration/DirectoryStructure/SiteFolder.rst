:navigation-title: Site folder

..  include:: /Includes.rst.txt
..  _site-folder:

====================================================
The site folder `config/sites/` / `typo3conf/sites/`
====================================================

The site folder (:file:`config/sites/my-site` in Composer-based installations,
:file:`typo3conf/sites/my-site` in Classic mode installations) **must** contain the
following file:

..  typo3:file:: config.yaml
    :name: site-config-yaml
    :scope: site
    :composerPath: /config/sites/my-site/
    :classicPath: /typo3conf/sites/my-site/
    :regex: /^.*(config|typo3conf)\/sites\/[\w-]+\/config\.yaml$/
    :shortDescription: Contains the site configuration

    Contains the site configuration. See chapter
    `Site handling <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_
    for details.

    The file is automatically created if you use the
    :guilabel:`Sites > Setup` module to
    `create a new site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling-create-new>`_.

    The name of the folder is editable as **Site Identifier** in the site
    configuration form.

..  contents:: Optional files in the site folder

..  _site-folder-settings:

Site settings `settings.yaml` in the site folder
================================================

..  typo3:file:: settings.yaml
    :name: site-settings-yaml
    :scope: site
    :composerPath: /config/sites/my-site/
    :classicPath: /typo3conf/sites/my-site/
    :regex: /^.*(config|typo3conf)\/sites\/[\w-]+\/settings\.yaml$/
    :shortDescription: Site specific settings

    This file stores all changes that where made to the site settings using the
    backend module :guilabel:`Sites > Setup > Settings`. It overrides the
    settings from all included site sets, including the set of the site package.

    ..  seealso::

        *   `Site settings <https://docs.typo3.org/permalink/t3coreapi:sitehandling-settings>`_.
        *   `Module Sites > Setup > Settings <https://docs.typo3.org/permalink/t3coreapi:site-settings-editor>`_


    ..  versionchanged:: 13.4.15

        The settings in :file:`settings.yaml` are stored as map instead of tree.

        `Important: #106894 - Site settings.yaml is now stored as a map <https://docs.typo3.org/permalink/changelog:important-106894-1750144877>`_

..  _site-folder-typoscript:

The site as frontend TypoScript provider
========================================

If the site should be used as TypoScript provider
(see `Site as a TypoScript provider <https://docs.typo3.org/permalink/t3tsref:typoscript-site-sets-site>`_)
it can contain the following files:

..  typo3:file:: constants.typoscript
    :name: site-constants-typoscript
    :scope: site
    :composerPath: /config/sites/my-site/
    :classicPath: /typo3conf/sites/my-site/
    :regex: /^.*(config|typo3conf)\/sites\/[\w-]+\/constants\.typoscript$/
    :shortDescription: Contains the TypoScript constants of a site

    Contains the TypoScript constants of a site.

..  typo3:file:: setup.typoscript
    :name: site-setup-typoscript
    :scope: site
    :composerPath: /config/sites/my-site/
    :classicPath: /typo3conf/sites/my-site/
    :regex: /^.*(config|typo3conf)\/sites\/[\w-]+\/setup\.typoscript$/
    :shortDescription: Contains the TypoScript setup of a site

    Contains the TypoScript setup of a site.

..  _site-folder-page-tsconfig:

Page TSconfig in the site folder
================================

..  typo3:file:: page.tsconfig
    :name: site-page-typoscript
    :scope: site
    :composerPath: /config/sites/my-site/
    :classicPath: /typo3conf/sites/my-site/
    :regex: /^.*(config|typo3conf)\/sites\/[\w-]+\/page\.tsconfig$/
    :shortDescription: Page TSconfig in this file is automatically loaded within the site scope

    Page TSconfig in this file is automatically loaded within the site scope.
    See also `Page TSconfig on site level <https://docs.typo3.org/permalink/t3tsref:include-static-page-tsconfig-per-site>`_.

..  _site-folder-configuration:

Additional configuration files in the site folder
=================================================

The site folder may also contain the following file:

..  typo3:file:: csp.yaml
    :scope: site
    :composerPath: /config/sites/my-site/
    :classicPath: /typo3conf/sites/my-site/
    :regex: /^.*(config|typo3conf)\/sites\/\w+\/csp\.yaml$/
    :shortDescription: Content Security Policy

    Used for a
    :ref:`site-specific Content Security Policy <content-security-policy-site>`.
