.. include:: /Includes.rst.txt
.. index:: Site handling; Settings
.. _sitehandling-settings:

=============
Site settings
=============

It is possible to define a `settings` block in a site's :file:`config.yml` which
can be accessed both in backend and frontend via the site object.

Additionally, these settings are available as "constants" in both TSConfig
and TypoScript templates making it possible to configure for example site-wide
storage PIDs which can be used in both frontend and backend.

Adding site settings
====================

Add a `settings` block to the :file:`config.yml`:

.. code-block:: yaml

   settings:
      categoryPid: 658
      styles:
         content:
            loginform:
               pid: 23

.. note::

   This example shows how to fill a constant of EXT:felogin via site settings (`styles.content.loginform.pid`) and
   configures a custom `categoryPid`.


.. index:: Site handling; TypoScript access to settings

Accessing site settings in page TSConfig or TypoScript
======================================================

.. code-block:: typoscript

   // store tx_ext_data records on the given storage page by default (e.g. through IRRE)
   TCAdefaults.tx_ext_data.pid = {$categoryPid}

   // load category selection for plugin from out dedicated storage page
   TCEFORM.tt_content.pi_flexform.ext_pi1.sDEF.categories.PAGE_TSCONFIG_ID = {$categoryPid}


.. note::

   The TypoScript constants are evaluated in this order:

   #. Global :php:`'defaultTypoScript_constants'`
   #. Site specific settings from the site configuration
   #. Constants from :sql:`sys_template` database records
