:navigation-title: Settings & Configuration

..  include:: /Includes.rst.txt
..  _configuration-glossary:
..  _configuration-classification:
..  _configuration:

=====================================================
Settings and Configuration of TYPO3 systems and sites
=====================================================

Settings can generally be adjusted through the TYPO3 backend by users with
the appropriate permissions.

*   **System-wide settings:** These typically require a user with the
    `System Maintainer <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_
    role in the `Admin Tools <https://docs.typo3.org/permalink/t3start:admin-tools>`_
    backend modules.
*   **Site-specific settings:** Settings for an individual domain are usually
    managed by backend `Administrators
    <https://docs.typo3.org/permalink/t3coreapi:admin-user>`_. They can be made
    in the `Site settings module <https://docs.typo3.org/permalink/t3coreapi:site-settings-editor>`_
    and the `Site configuration module <https://docs.typo3.org/permalink/t3coreapi:sitehandling-create-new>`_.
*   **Page or content element settings:** Editors can modify these settings
    provided they have the necessary permissions. Settings on page level can
    commonly be adjusted in the `Page properties <https://docs.typo3.org/permalink/t3editors:pages-properties>`_.
    Content elements and plugins can offer settings in the content element
    editor.

While configuration might seem similar to settings, they serve different
roles. Configuration refers to static parameters defined in files that
establish system behavior and are commonly changed by developers or
integrators who can modify and deploy these files. Settings, on the other
hand, are dynamic options that users adjust through the backend.

The `Configuration module
<https://docs.typo3.org/permalink/t3coreapi:config-module>`_ gives
administrators an overview of configuration values including those that can
only be changed during deployment.

**Table of Contents**

..  toctree::
    :maxdepth: 1

    ConfigurationOverview
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
