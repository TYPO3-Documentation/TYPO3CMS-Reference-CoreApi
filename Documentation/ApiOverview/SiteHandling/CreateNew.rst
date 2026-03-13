:navigation-title: Creation
..  include:: /Includes.rst.txt
..  index:: Site handling; Create new
..  _sitehandling-create-new:

=================================
Creating a new site configuration
=================================

A new site configuration is automatically created for each
**new page on the rootlevel (pid = 0)** and each
**page with the "is_siteroot" flag set**.

To customize the automatically created site configuration,
go to the :guilabel:`Sites > Setup` module.

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingCreateNewSite-1.rst.txt

You can edit a site by clicking on the :guilabel:`Edit` icon (the pencil). If
for some reason no site configuration was created, there will be a button to
create one:

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingNoSite.rst.txt

The site configuration form looks like this:

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingCreateNewSite-2.rst.txt

It is recommended to change the following fields:

:guilabel:`Site Identifier`
    The site identifier is the name of the folder within
    :file:`<project-root>/config/sites/` that will hold your configuration
    file(s). When choosing an identifier, make sure to stick to ASCII, but for
    convenience you may also use `-`, `_` and `.`.

    Examples: `main-site` and `landing-page`.

:guilabel:`Entry Point`
    Be as specific as you can for your sites without losing flexibility. So, if
    you have a choice between using :samp:`https://example.org`,
    :samp:`example.org` or :samp:`/`, then choose :samp:`https://example.org`.

    This makes the resolving of pages more reliable by minimizing the risk of
    conflicts with other sites.

If you need to use another domain in development, for example
`https://example.ddev.site`, it is recommended to use
:ref:`base variants <sitehandling-baseVariants>`.

The next tab, :guilabel:`Languages`, lets you configure the default
language settings for your site. You can also add additional languages for
multilingual sites here.

These settings determine the default behavior - the entry point of the
site language in frontend as well as locale settings.

You can choose

1.  to create a new language defining all values by yourself
    (:guilabel:`Create new language`)
2.  from a list of default language settings
    (:guilabel:`Choose a preset ...`)
3.  to use an existing language, if it is already used in a different site
    (:guilabel:`Use language from existing site ...`)

Although 3. is always recommended when working with multi-site setups to keep
language IDs between sites in sync, 2. is a quick start to set up a new site.

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingCreateNewSite-3.rst.txt

Check and correct all other settings as they will be automatically used for
features like the locale or displaying language flags in the backend.

That is all that is required for a new site.

..  tip::
    Just by having a site configuration, you get readable page URLs out of
    the box. Read more about how to configure :ref:`routing <routing>`.

Learn more about :ref:`adding languages <sitehandling-addingLanguages>`,
:ref:`error handling <sitehandling-errorHandling>` and :ref:`routing <routing>`
in the corresponding chapters.
