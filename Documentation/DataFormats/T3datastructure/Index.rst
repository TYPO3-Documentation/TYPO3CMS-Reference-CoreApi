.. include:: ../../Includes.txt


.. _t3ds:

===============
T3DataStructure
===============

TYPO3 offers an XML format, T3DataStructure, which defines a
hierarchical data structure. In itself the data structure definition
doesn't do much - it is only a back bone for higher level applications
which can add their own configuration inside.

Such applications can be:

- :ref:`FlexForms <t3tca:columns-flex>` - a TCEform type which will allow users to build
  information hierarchies (in XML) according to the Data Structure. In
  this sense the Data Structure is like a DTD (Document Type
  Definition) for the backend which can render a dynamic form based on
  the Data Structure;

- `TemplaVoila! <http://typo3.org/extensions/repository/view/templavoila>`_ -
  an extension which uses the Data Structure as backbone for mapping template HTML to data.

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


