.. include:: ../../Includes.txt

.. _best-practices:

==============
Best practices
==============

Following are some good practices for creating custom content element types and
plugins and for customizing content elements for usage in the backend.

* Use a sitepackage extension to maintain your site customization (such as
  backend layouts, custom content elements etc.)
* How you structure your extensions depends a little on the use case and if
  they will be resused in several projects and / or made public. If you create one
  extension for every custom content element, you may want to think about
  whether they might be merged into one or more extensions.
* Do not use deprecated functionality. Read the `Core Changelog <https://docs.typo3.org/c/typo3/cms-core/master/en-us/>`__
  to check for deprecations and breaking changes between TYPO3 versions.
* Some naming conventions are described in the chapter :ref:`extension-naming`.
* Read (or skim) the :ref:`cgl`.
* Make it easier for your editors by hiding the following by
  :ref:`configuration <cePluginsCustomize>`

  * content elements that should not be used in the "Content Element Wizard"
  * fields that should not be filled out in the backend forms.
