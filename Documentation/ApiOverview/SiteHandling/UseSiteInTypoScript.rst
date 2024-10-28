:navigation-title: Usage in TypoScript + Fluid
.. include:: /Includes.rst.txt
.. index:: pair: Site handling; TypoScript
.. _sitehandling-inTypoScript:

==========================================================
Using site configuration in TypoScript and Fluid templates
==========================================================

.. index:: pair: Site handling; getText

getText
=======

Site configuration can be accessed via the :ref:`site <t3tsref:data-type-site>` property in TypoScript.

Example:

.. code-block:: typoscript

    page.10 = TEXT
    page.10.data = site:base
    page.10.wrap = This is your base URL: |

Where :typoscript:`site` is the keyword for accessing an aspect, and the following parts are the
configuration key(s) to access.

.. code-block:: typoscript

    data = site:customConfigKey.nested.value

To access the current siteLanguage use the :ref:`siteLanguage <t3tsref:data-type-siteLanguage>` prefix:

.. code-block:: typoscript

     page.10 = TEXT
     page.10.data = siteLanguage:navigationTitle
     page.10.wrap = This is the title of the current site language: |

     page.10 = TEXT
     page.10.dataWrap = The current site language direction is {siteLanguage:direction}


.. tip::
    Accessing site configuration is possible in TypoScript, which enables to store site specific configuration options
    in one central place (the site configuration) and allows usage of that configuration from different contexts.
    While this sounds similar to using TypoScript constants, site configuration
    values may also be used from backend or CLI context as long as the rootPageId of a site is known.

Site configuration can also be used in :ref:`TypoScript conditions <sitehandling-inConditions>` and as
:ref:`TypoScript constants <sitehandling-settings>`.


.. index::
   Site handling; FLUIDTEMPLATE
   Site handling; SiteProcessor
   Site handling; Fluid
   SiteProcessor

.. _sitehandling-fluidtemplate:

FLUIDTEMPLATE
=============

You can use the SiteProcessor in the :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` content object
to fetch data from the site entity:

.. code-block:: typoscript

   tt_content.mycontent.20 = FLUIDTEMPLATE
   tt_content.mycontent.20 {
       file = EXT:myextension/Resources/Private/Templates/ContentObjects/MyContent.html

       dataProcessing.10 = TYPO3\CMS\Frontend\DataProcessing\SiteProcessor
       dataProcessing.10 {
           as = site
       }
   }

In the Fluid template the properties of the site entity can be accessed with:

.. code-block:: html

   <p>{site.rootPageId}</p>
   <p>{site.configuration.someCustomConfiguration}</p>

Specific :ref:`sitehandling-settings` can be accessed via:

.. code-block:: html

   <p>{site.configuration.settings.mySettingKey}</p>
   <p>{site.settings.all.mySettingKey}</p>

.. _sitehandling-non-extbase-fluid:

Non-Extbase Fluid view
======================

..  versionchanged:: 14.0
    The :php-short:`\TYPO3\CMS\Fluid\View\StandaloneView` was deprecated with
    TYPO3 v13.3 and has been removed with v14.0. Use a
    :php-short:`\TYPO3\CMS\Core\View\ViewInterface` instance provided by the
    :ref:`sitehandling-site-object`.

In a non-Extbase Fluid view (:php:`\TYPO3\CMS\Core\View\ViewInterface`), created
manually by the :ref:`generic-view-factory`, you can use the PHP API to access the
site settings (see :ref:`sitehandling-site-object`), then assign that object
to your Fluid standalone template, and finally access it through the same
notation in the :ref:`Fluid template of a FLUIDTEMPLATE <sitehandling-fluidtemplate>`.
