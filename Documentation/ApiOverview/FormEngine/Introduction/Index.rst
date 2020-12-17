.. include:: /Includes.rst.txt
.. _FormEngine-Introduction:

============
Introduction
============

Looking at TYPO3's main constructs from an abstract position, the system splits into three most important pillars:

DataHandler
  :php:`TYPO3\CMS\Core\DataHandling\...`: :ref:`Construct taking care of persisting data into the database <tce>`.
  The DataHandler takes an array representing one or more records, inserts, deletes or updates them in the database
  and takes care of relations between multiple records. If editing content in the backend, this construct does
  all main database munging. DataHandler is fed by some controller that most often gets :code:`GET`
  or :code:`POST` data from FormEngine.

FormEngine
  :php:`TYPO3\CMS\Backend\Form\...`: FormEngine renders records, usually in the backend. It creates all the HTML
  needed to edit complex data and data relations. Its :code:`GET` or :code:`POST` data is then fed to the DataHandler
  by some controller.

Frontend rendering
  :php:`TYPO3\CMS\Frontend\...`: Renders the website frontend. The frontend rendering, usually based on
  :php:`TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` uses :code:`TypoScript` and / or :code:`Fluid`
  to process and render database content into the frontend.

The glue between these three pillars is :ref:`TCA (Table Configuration Array) <t3tca:tca-what-is>`: It defines how
database tables are constructed, which localization or workspace facilities exist, how it should be displayed in the
backend, how it should be written to the database, and - next to TypoScript - which behaviour it has in the frontend.

This chapter is about FormEngine. It is important to understand this construct is based on TCA and is usually
used in combination with the DataHandler. However, FormEngine is constructed in a way that it can work without
DataHandler: A controller could use the FormEngine result and process it differently. Furthermore, all dependencies of
FormEngine are abstracted and may come from "elsewhere", still leading to the form output known for casual records.

This makes FormEngine an incredible flexible construct. The basic idea is "feed something that looks like TCA
and render forms that have the full power of TCA but look like all other parts of the backend".

The FormEngine code base has been significantly refactored in TYPO3 CMS version 7 and version 8 to be much more
flexible, more easy to use and extend, and much more powerful than before. This is an ongoing process and some
areas still need a major overhaul. The current state of the documentation aims to explain the main constructs of
FormEngine and gives an insight on how to re-use, adapt and extend it with extensions. The core team expects to see more
usages of FormEngine within core itself and within extensions in the future, and encourages developers to solve
feature needs based on FormEngine. With the ongoing changes, those areas that may need code adaptions in the
foreseeable future have notes within the documentation and developers should be available to adapt with younger
cores. Watch out for breaking changes if using FormEngine and updating core.
