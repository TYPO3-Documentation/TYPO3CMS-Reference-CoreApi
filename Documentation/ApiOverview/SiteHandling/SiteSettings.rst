..  include:: /Includes.rst.txt
..  index:: Site handling; Settings
..  _sitehandling-settings:

=============
Site settings
=============

..  versionadded:: 13.1
    Site settings can receive a type, a default value and some documentation in
    :ref:`site settings definitions <site-sets-settings-definition>`. It is
    recommended to always define a site setting before using it, as only this way
    you can ensure proper types and default values.

..  versionchanged:: 13.4.15

    The settings in :file:`settings.yaml` are stored as map instead of tree.

    `Important: #106894 - Site settings.yaml is now stored as a map <https://docs.typo3.org/permalink/changelog:important-106894-1750144877>`_

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

All changed values in the site settings editor are stored in the `settings.yaml`
file of the `config/sites/<my_site>/` directory. If this file does not exist,
it will be created.

..  note::
    You *can* make use of `imports` here, but with next storing process of
    site settings editor all your `imports` are gone.

To store values independant from site settings editor, use the `settings.yaml`
file in folder `Configuration/Sets/<my_site>/` of your site package. The file
itself will kept untouched, but the values will be overwritten by values from the
`settings.yaml` in the `config/sites/<my_site>/`.

..  note::
    As this file is independant from external modification, you can make use
    of `imports` here, if needed. Absolute paths, relative paths and of cause
    `EXT:` usage is allowed here.


..  _sitehandling-settings-add:

Adding site settings
====================

Add settings to the :file:`settings.yaml <set-settings-yaml>`:

..  literalinclude:: _site-settings.yaml
    :language: yaml
    :caption: config/sites/<my_site>/settings.yaml | typo3conf/sites/<my_site>/settings.yaml

..  versionchanged:: 13.4.15

    The settings in :file:`settings.yaml` are stored as map instead of tree.

    `Important: #106894 - Site settings.yaml is now stored as a map <https://docs.typo3.org/permalink/changelog:important-106894-1750144877>`_

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
