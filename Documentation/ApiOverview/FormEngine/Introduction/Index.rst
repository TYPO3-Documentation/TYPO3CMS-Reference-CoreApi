.. include:: /Includes.rst.txt
.. _FormEngine-Introduction:

============
Introduction
============

Looking at TYPO3's main constructs from an abstract position, the system splits into three most important pillars:

`DataHandler`:pn:
  :php:`TYPO3\CMS\Core\DataHandling\...`: :ref:`Construct taking care of persisting data into the database <tce>`.
  The `DataHandler`:pn: takes an array representing one or more records, inserts, deletes or updates them in the database
  and takes care of relations between multiple records. If editing content in the backend, this construct does
  all main database munging. `DataHandler`:pn: is fed by some controller that most often gets :code:`GET`
  or :code:`POST` data from the `FormEngine`:pn:.

`FormEngine`:pn:
  :php:`TYPO3\CMS\Backend\Form\...`: The `FormEngine`:pn: renders records, usually in the backend. It creates all the HTML
  needed to edit complex data and data relations. Its :code:`GET` or :code:`POST` data is then fed to the `DataHandler`:pn:
  by some controller.

Frontend rendering
  :php:`TYPO3\CMS\Frontend\...`: Renders the website frontend. The frontend rendering, usually based on
  :php:`TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` uses :pn:`TypoScript` and / or :pn:`Fluid`
  to process and render database content into the frontend.

The glue between these three pillars is :ref:`TCA (Table Configuration Array) <t3tca:tca-what-is>`: It defines how
database tables are constructed, which localization or workspace facilities exist, how it should be displayed in the
backend, how it should be written to the database, and - next to `TypoScript`:pn: - which behaviour it has in the frontend.

This chapter is about hte `FormEngine`:pn:. It is important to understand this construct is based on `TCA`:pn: and is usually
used in combination with the `DataHandler`:pn:. However, the `FormEngine`:pn: is constructed in a way that it can work without
`DataHandler`:pn:: A controller could use the `FormEngine`:pn: result and process it differently. Furthermore, all dependencies of
the `FormEngine`:pn: are abstracted and may come from "elsewhere", still leading to the form output known for casual records.

This makes the `FormEngine`:pn: an incredible flexible construct. The basic idea is "feed something that looks like `TCA`:pn:
and render forms that have the full power of `TCA`:pn: but look like all other parts of the backend".

The `FormEngine`:pn: code base has been significantly refactored in `TYPO3 CMS`:pn: version 7 and version 8 to be much more
flexible, more easy to use and extend, and much more powerful than before. This is an ongoing process and some
areas still need a major overhaul. The current state of the documentation aims to explain the main constructs of
the `FormEngine`:pn: and gives an insight on how to re-use, adapt and extend it with extensions. The `Core Team`:pn: expects to see more
usages of the `FormEngine`:pn: within the `Core`:pn: itself and within extensions in the future, and encourages developers to solve
feature needs based on `FormEngine`:pn:. With the ongoing changes, those areas that may need code adaptions in the
foreseeable future have notes within the documentation and developers should be available to adapt with younger
cores. Watch out for breaking changes if using `FormEngine`:pn: and updating the `Core`:pn:.
