..  include:: /Includes.rst.txt
..  index:: Site handling; Settings
..  _sitehandling-settings:

=============
Site settings
=============

It is possible to define a :yaml:`settings` block in a site's
:file:`config.yaml` which can be accessed both in backend and frontend via the
site object :php:`\TYPO3\CMS\core\Site\Entity\Site`.

Additionally, these settings are available in both
:ref:`page TSconfig <t3tsconfig:pagetsconfig>` and
:doc:`TypoScript templates <t3tsref:Index>`. This allows us, for example, to
configure site-wide storage page IDs which can be used in both frontend and
backend.

Adding site settings
====================

Add a :yaml:`settings` block to the :file:`config.yaml`:

..  literalinclude:: _site-settings.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

..  note::
    This example shows how to fill a constant of
    :doc:`EXT:felogin <ext_felogin:Index>` via site settings
    (:typoscript:`styles.content.loginform.pid`) and configures a custom
    :yaml:`categoryPid`.


..  index:: Site handling; TypoScript access to settings

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
