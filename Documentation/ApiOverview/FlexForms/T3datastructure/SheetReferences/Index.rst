:navigation-title: Sheet References

..  include:: /Includes.rst.txt
..  _t3ds-sheet-references:
..  _t3ds-sheet-references-example:

==============================================
Sheet reference support in the T3DataStructure
==============================================

If Data Structures are arranged in a collection of sheets you can
choose to store one or more sheets externally in separate files. This
is done by setting the value of the `<[sheet ident]>` tag to a relative
file reference instead of being a definition of the `<ROOT>` element.

Main Data Structure:

..  literalinclude:: _Main.xml
    :caption: EXT:my_extension/Configuration/FlexForms/MyFlexForm.xml

..  literalinclude:: _DefaultSheet.xml
    :caption: EXT:my_extension/Configuration/FlexForms/sheets/DefaultSheet.xml

and the same for the other sheet :file:`WelcomeSheet.xml`.

..  warning::
    Sheet references are not resolved by default and rely on the application
    interpreting the data structure.
