.. include:: /Includes.rst.txt


.. _t3ds:

===============
T3DataStructure
===============

TYPO3 offers an XML format, T3DataStructure, which defines a
hierarchical data structure. In itself the data structure definition
does not do much - it is only a back bone for higher level applications
which can add their own configuration inside.

The T3DataStructure could be used for different applications in theory, however it
is commonly only used in the context of FlexForms.

FlexForms are used in the contexts:

-  TCA form type :ref:`FlexForms <t3tca:columns-flex>`:
   The type allows users to build
   information hierarchies (in XML) according to the data structure. In
   this sense the Data Structure is like a DTD (Document Type
   Definition) for the backend which can render a dynamic form based on
   the Data Structure.
   
-  The configuration of plugins of many common extensions with FlexForms like 
   `news <https://extensions.typo3.org/extension/news>`__. 
   
-  FlexForms can be used for containers created by the extensions like
   `container <https://extensions.typo3.org/extension/container>`__ or 
   `gridelements <https://extensions.typo3.org/extension/gridelements>`__

-  `dce <https://extensions.typo3.org/extension/dce>`__ an extension to create 
   FlexForm based content elements.

This documentation of a data structure will document the general
aspects of the XML format and leave the details about FlexForms and
TemplaVoila to be documented elsewhere.

Some other facts about Data Structures (DS):

- A Data Structure is defined in XML with the document tag named
  "<T3DataStructure>"

- The XML format generally complies with what can be converted into a
  PHP array by :php:`GeneralUtility::xml2array()` - thus it directly reflects how a
  multidimensional PHP array is constructed.

- A Data Structure can be arranged in a set of "sheets". The purpose of
  sheets will depend on the application. Basically sheets are like a
  one-dimensional internal categorization of Data Structures.

- Parsing a Data Structure into a PHP array is incredibly easy - just
  pass it to :php:`GeneralUtility::xml2array()` (see the :ref:`t3ds-parsing` section).

- "DS" is sometimes used as short for Data Structure


**Next chapters**

.. toctree::
   :titlesonly:

   Elements/Index
   SheetReferences/Index
   Parsing/Index
