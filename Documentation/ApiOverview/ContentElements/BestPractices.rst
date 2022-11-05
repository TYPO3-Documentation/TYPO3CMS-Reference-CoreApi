.. include:: /Includes.rst.txt

.. _best-practices:

==============
Best practices
==============

Following are some good practices for creating custom content element types and
plugins and for customizing content elements for usage in the backend.

Coding / structure
==================

* Use a sitepackage extension to maintain your site customization (such as
  backend layouts, custom content elements etc.)
* How you structure your extensions depends a little on the use case and if
  they will be reused in several projects and / or made public. If you create one
  extension for every custom content element, you may want to think about
  whether they might be merged into one extension.
* Do not use deprecated functionality. Read the :doc:`Core Changelog <ext_core:Index>`
  to check for deprecations and breaking changes between TYPO3 versions.
* Some naming conventions are described in the chapter :ref:`extension-naming`.
* Read (or skim) the :ref:`cgl`.

Backend usability
=================

* Make it easier for your editors by hiding the following by
  :ref:`configuration <cePluginsCustomize>`

  * content elements that should not be used in the "Content Element Wizard"
  * fields that should not be filled out in the backend forms.
