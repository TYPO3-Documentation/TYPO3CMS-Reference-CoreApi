:navigation-title: T3DataStructure

..  include:: /Includes.rst.txt
..  _t3ds:

============================================
T3DataStructure, the format behind FlexForms
============================================

TYPO3’s **T3DataStructure** is an XML format for defining hierarchical data.

On its own, it serves only as a backbone. Applications such as
`FlexForms <https://docs.typo3.org/permalink/t3coreapi:flexforms>`_ build
upon it with their own configuration.

While it could be used in other contexts, it is almost always tied to
FlexForms. This documentation covers the general XML format, leaving FlexForms
details to their own section.

**Key facts:**

-   Defined in XML with a root ``<T3DataStructure>`` tag.
-   Compatible with :php:`GeneralUtility::xml2array()`, mapping directly to a
    multidimensional PHP array.
-   Can be divided into *sheets*, a one-dimensional categorization whose purpose
    depends on the application.
-   Parsing to a PHP array is done via :php:`GeneralUtility::xml2array()` (see
    :ref:`t3ds-parsing`).
-   “DS” is shorthand for Data Structure.

**Next chapters**

..  toctree::
    :titlesonly:

    Elements/Index
    SheetReferences/Index
    Parsing/Index
