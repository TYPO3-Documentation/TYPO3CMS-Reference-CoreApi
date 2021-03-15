.. include:: /Includes.rst.txt

.. _sitehandling-inTypoScript:

======================================
Using Site Configuration in TypoScript
======================================

getText
~~~~~~~

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
    While this sounds similar to using TypoScript, with using site configuration this may also be used from backend
    or CLI context as long as the rootPageId of the site is known. To avoid duplicating configuration options,
    TypoScript can now access these properties, too.

Site configuration can also be used in :ref:`TypoScript conditions <sitehandling-inConditions>` and as
:ref:`TypoScript constants <sitehandling-settings>`.

FLUIDTEMPLATE
~~~~~~~~~~~~~

You can use the SiteProcessor in the The :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` content object
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
   <p>{site.someCustomConfiguration}</p>
