:navigation-title: Settings & Config

..  include:: /Includes.rst.txt
..  _configuration-glossary:
..  _configuration-classification:
..  _configuration:

=====================================================
Settings and Configuration of TYPO3 systems and sites
=====================================================

TYPO3 settings can be changed in the backend, depending on the logged-in user's
role:

System-wide settings
    Can be changed by `System Maintainers <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_
    in the :guilabel:`System > Settings` module.

Site-specific settings
    Can be changed by backend
    `Administrators <https://docs.typo3.org/permalink/t3coreapi:admin-user>`_
    in the :guilabel:`Site Settings` and :guilabel:`Site Configuration` modules.

Page/content element settings
    Can be changed by Editors with the correct permissions
    in :guilabel:`Page properties` and in the content element editor.

Settings are values that can be changed in the backend by users with the appropriate permissions
whereas configuration refers to static parameters in files that can only be
changed by developers and integrators.

**Table of Contents**

..  toctree::
    :maxdepth: 1

    ConfigurationOverview
    Modules/Index
    GlobalVariables
    Typo3ConfVars/Index
    TypoScript/Index
    UserSettingsConfiguration/Index

..  seealso::

    * :ref:`Caching configuration <caching-configuration>`
    * :ref:`Extension configuration <extension-configuration>`
    * :ref:`Extension configuration files <extension-files-locations>`
    * :ref:`Flexforms <flexforms>`
    * :ref:`Form Framework <ext_form:concepts-configuration>` (form)
    * :ref:`Logging configuration <logging-configuration>`
    * :ref:`Rich text configuration <ext_rte_ckeditor:configuration>` (rte_ckeditor)
    * :ref:`Site, language, routing configuration <sitehandling>`
    * :ref:`TCA Reference <t3tca:start>`
    * :ref:`TypoScript Explained <t3tsref:start>`
