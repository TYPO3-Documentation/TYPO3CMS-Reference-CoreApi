.. include:: /Includes.rst.txt
.. index:: Site handling; Create new
.. _sitehandling-create-new:

=================================
Creating a new site configuration
=================================

A new site configuration is automatically created for each
**new page on the rootlevel (pid = 0)** and each
**page with the `is_siteroot` flag set**.

To adjust the automatically created site configuration,
go to module :guilabel:`Site Management > Sites`.

.. include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingCreateNewSite-1.rst.txt

You can edit it by clicking on the Edit icon. If for some reason no site
configuration was created there will be a button to create one:

.. include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingNoSite.rst.txt

The site configuration looks like this:

.. include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingCreateNewSite-2.rst.txt

It is recommended to change the following fields:

*  The :guilabel:`Site Identifier`

   .. hint::

      The site identifier is the name of the folder within
      :file:`<project-root>/config/sites/` that will hold your
      configuration file(s). When choosing an identifier make sure to stick
      to ASCII but you may also use `-`, `_` and `.` for convenience.
      Examples: `main-site` and `landing-page`.

*  The :guilabel:`Entry Point`

   .. tip::
      Be as specific as you can for your sites without losing flexibility.
      So, if you have a choice between using `https://example.org`,
      `example.org` or `/`, then choose `https://example.org`.

      This will make resolving pages more reliable as the chance for conflicts
      with other sites gets minimized.

If you need to use another domain in development, for example
`https://example.ddev.site` it is recommended to use
:ref:`Base variants <sitehandling-baseVariants>`.

On the next tab :guilabel:`Languages` you are can configure the default
language settings for your site. You can also add additional languages for
multilanguage sites here.

These settings determine the default behavior - setting direction and lang tags
in frontend as well as locale settings.

.. include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingCreateNewSite-3.rst.txt

Check and correct all other settings, as they will automatically
be used for features like hreflang tags or displaying language flags in the
backend.

That's all that is required for a new site.

.. tip::
   Just by having a site configuration you get human-readable page URLs out of the
   box. Read more about how to configure the :ref:`routing <routing>`.

Learn more about :ref:`adding languages <sitehandling-addingLanguages>`,
:ref:`error handling <sitehandling-errorHandling>` and :ref:`routing <routing>`
in the corresponding chapters.
