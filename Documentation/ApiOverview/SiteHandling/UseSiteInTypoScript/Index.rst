.. include:: ../../../Includes.txt


.. _sitehandling-basics:

Using Site Configuration in TypoScript
--------------------------------------

Site configuration can be accessed via the :typoscript:`getText` property in TypoScript.

Example:

.. code-block:: typoscript

	page.10 = TEXT
	page.10.data = site:base
	page.10.wrap = This is your base URL: |

Where :typoscript:`site` is the keyword for accessing an aspect, and the following parts are the configuration key(s) to access.

.. code-block:: typoscript

	data = site:customConfigKey.nested.value
    
.. tip::
    Accessing site configuration is possible in TypoScript, which enables to store site specific configuration options
    in one central place (the site configuration) and allows usage of that configuration from different contexts. 
    While this sounds similar to using TypoScript, with using site configuration this may also be used from backend 
    or CLI context as long as the rootPageId of the site is known. To avoid duplicating configuration options, 
    TypoScript can now access these properties, too.

Site configuration can also be used in :ref:`TypoScript conditions <sitehandling-inConditions>`.