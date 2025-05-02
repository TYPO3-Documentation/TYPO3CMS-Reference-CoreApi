:navigation-title: Settings & Config

..  include:: /Includes.rst.txt
..  _configuration-glossary:
..  _configuration-classification:
..  _configuration:

=====================================================
Settings and Configuration of TYPO3 systems and sites
=====================================================

Settings in TYPO3 can be adjusted through the backend, depending on user roles:

System-wide settings
    Require a user with the
    `System Maintainer <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_
    role via the :guilabel:`Admin Tools` module.

Site-specific settings
    Managed by backend
    `Administrators <https://docs.typo3.org/permalink/t3coreapi:admin-user>`_
    via the :guilabel:`Site Settings` and :guilabel:`Site Configuration` modules.

Page/content element settings
    Editors with permissions can change these
    via :guilabel:`Page properties` or directly in the content element editor.

Settings are dynamic values modified via the backend. Configuration refers to
static parameters in files, typically managed by developers or integrators.

**Table of Contents**

..  toctree::
    :maxdepth: 1

    ConfigurationOverview
    ConfigurationFiles
    ConfigurationModule/Index
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
