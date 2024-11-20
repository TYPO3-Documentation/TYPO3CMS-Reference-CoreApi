..  include:: /Includes.rst.txt
..  index:: Site handling; Settings
..  _sitehandling-settings:

=============
Site settings
=============

..  versionchanged:: 12.1
    Before TYPO3 v12.1 the site settings were stored in the :file:`config.yaml`
    file under the :yaml:`settings` key. An upgrade wizard copies the settings
    to the new :file:`settings.yaml` file.

    Settings are not removed from the :file:`config.yaml` file for now, but will
    not have any effect anymore as soon as a :file:`settings.yaml` file exists.

    Please review your settings in the :file:`config.yaml` file and remove them
    manually. Eventually, you need and/or want to adopt your deployment
    workflow.

Site settings can be used to provide settings for a site. They can be accessed
via

*   the :ref:`\\TYPO3\\CMS\\Core\\Site\\Entity\\Site <sitehandling-site-object>`
    object in frontend and backend context using PHP
*   the :ref:`siteSettings <t3tsref:data-type-siteSettings>` key of the
    :ref:`data <t3tsref:data-type-gettext>` function in
    :ref:`TypoScript <t3tsref:start>`
*   constants in :ref:`TypoScript <t3tsref:start>` or :ref:`page TSconfig <t3tsref:pagetsconfig>`
*   as variables (for example, :fluid:`{site.configuration.settings.mySettingKey}`) in Fluid templates
    using the :typoscript:`SiteProcessor data processor`, see :ref:`<sitehandling-inTypoScript`.

For instance, settings can be used in custom frontend code to deliver features
which might vary per site for extensions. An example may be to configure
storage page IDs.

The settings are defined in the :file:`config/sites/<my_site>/settings.yaml`
file.

..  _sitehandling-settings-add:

Adding site settings
====================

Add settings to the :file:`settings.yaml`:

..  literalinclude:: _site-settings.yaml
    :language: yaml
    :caption: config/sites/<my_site>/settings.yaml | typo3conf/sites/<my_site>/settings.yaml

..  note::
    This example shows how to fill a constant of
    :doc:`EXT:felogin <ext_felogin:Index>` via site settings
    (:typoscript:`styles.content.loginform.pid`) and configures a custom
    :yaml:`categoryPid`.


..  index:: Site handling; TypoScript access to settings
..  _sitehandling-settings-access:

Accessing site settings in page TSconfig or TypoScript
======================================================

..  code-block:: typoscript

    // store tx_ext_data records on the given storage page by default (e.g. through IRRE)
    TCAdefaults.tx_ext_data.pid = {$categoryPid}

    // load category selection for plugin from out dedicated storage page
    TCEFORM.tt_content.pi_flexform.ext_pi1.sDEF.categories.PAGE_TSCONFIG_ID = {$categoryPid}

..  note::
    The TypoScript constants are evaluated in this order:

    #.  Configuration from
        :ref:`$GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_constants']
        <typo3ConfVars_fe_defaultTypoScript_constants>`
    #.  Site specific settings from the site configuration
    #.  Constants from :sql:`sys_template` database records
