:navigation-title: Elements

..  include:: /Includes.rst.txt
..  _t3ds-elements:

===============================
XML Elements in T3DataStructure
===============================

This is the list of elements and their nesting in the Data Structure.

..  contents::

..  _t3ds-elements-array:

Elements Nesting Other Elements ("Array" Elements)
==================================================

All elements defined here cannot contain a string value but  *must*
contain a set of elements.

(In a PHP array this corresponds to saying that all these elements
must be arrays.)

..  versionchanged:: 12.0
    The superfluous array key `TCEforms` was removed and is not evaluated
    anymore. Its sole purpose was to wrap real TCA definitions. The `TCEforms` tags **should**
    be removed upon dropping TYPO3 v11 support. In TYPO3 v12 there is an automatic migration
    that will be removed in a future version.

..  confval:: <T3DataStructure>
    :name: t3datastructure
    :type: array

    This is the root element of a T3DataStructure. It may contain tags
    `<meta>` and `<ROOT>` or `<sheets>`

..  confval:: <T3DataStructure>
    :name: t3datastructure-meta
    :type: array

    Can contain application specific meta settings. Interpretation depends on
    the application using the T3DataStructure. Each setting goes to a XML tag.

..  confval:: <ROOT>
    :name: t3datastructure-root
    :type: array

    Defines an "object" in the Data Structure

    Tag `<ROOT>` is reserved for the first element in the Data
    Structure. The `<ROOT>` tag must have a `<type>` tag with the value
    "array" as child and then define other objects nested in `<el>` tags.

    Can have the following child tags: `<type>`, `<section>`, `<el>`
    `<[application tag]>`.

..  confval:: <[field name]>
    :name: t3datastructure-field-name
    :type: array

    Defines an "object" in the Data Structure, `[field name]` defines the
    objects name.

    Can have the same child tags like `<ROOT>`.

..  confval:: <sheets>
    :name: t3datastructure-sheets
    :type: array

    Defines a collection of "sheets" which is like a one-dimensional list
    of independent Data Structures.

    Contains `<[sheet name]>` tags for the actual sheets.

..  confval:: <sheetTitle>
    :name: t3datastructure-sheet-title
    :type: string or LLL reference

    Title of the sheet. Mandatory for any sheet except the first (which
    gets "General" in this case). Can be a plain string or a reference to
    a language file using standard LLL syntax. Ignored if sheets are not
    defined for the FlexForm.

..  confval:: <displayCond>
    :name: t3datastructure-display-cond
    :type: array

    Condition that must be met in order for the sheet to be displayed.
    If the condition is not met, the sheet is hidden.

    For more details refer to the description of the "displayCond" property
    in the :ref:`TCA Reference <t3tca:columns>`.

..  confval:: <[sheet ident]>
    :name: t3datastructure-sheet-ident
    :type: array

    Defines an independent data structure starting with a `<ROOT>` tag.

    Alternatively, it can be a plain value referring to another
    XML file which contains the <ROOT> structure. See example later.

..  confval:: <el>
    :name: t3datastructure-el
    :type: array

    Contains a collection of Data Structure "objects"

Elements can use the attribute :xml:`type` to define their type, for example
they can explicitly use boolean.

An example would look like:

..  code-block:: xml

    <required type="boolean">1</required>

..  _t3ds-elements-value:

Elements Containing Values ("Value" Elements)
=============================================

All elements defined here must contain a string value and no other XML
tags whatsoever!

(In a PHP array this corresponds to saying that all these elements
must be strings or integers.)

..  confval:: <type>
    :name: t3datastructure-type
    :type: Keyword string: `"array"`, `""` (blank)
    :default: `""` (blank)

    Defines the type of object.

    `"array"`
        The parent tag contains a collection of other
        objects defined inside the <el> tag on the same level. If the value is
         `"array"` you can use the tag `<section>`. See below.

    `""` (blank)
        The parent does not contain sub objects. The
        meaning of an object is determined by the application using the
        data structure. For FlexForms this object would draw a form element.

    If the parent is `<ROOT>` this tag must have the value `"array"`.

..  confval:: <section>
    :name: t3datastructure-section
    :type: Boolean
    :default: `""` (blank)

    Defines that an object of type <array> must contain other
    "array" objects in each item of <el>. The meaning of this is application specific. For
    FlexForms it will allow the user to select between possible arrays of
    objects that they can create in the form. This is similar to the concept of
    :ref:`IRRE / inline TCA definitions <t3tca:columns-inline>`.

..  versionchanged:: 13.0

    Available element types inside FlexForm sections is
    restricted. You should only use simple TCA types like
    :php:`type => 'input'` in sections. Relations (:php:`type =>
    'group'`, :php:`type => 'inline'`, :php:`type => 'select'` and similar)
    should be avoided.
    TYPO3 v13 forbids using :php:`type => 'select'` with
    a :php:`foreign_table` set, which will raise an exception.
    This does not apply for FlexForm fields outside of a :xml:`<section>`.
    Details can be found in
    :ref:`ext_core:breaking-102970-1706447911`.


..  _t3ds-elements-example:

T3DataStructure example: A simple FlexForm
==========================================

Below is the structure of a basic FlexForm from the example extension
:composer:`typo3/cms-styleguide`:

..  include:: /CodeSnippets/FlexForms/Simple.rst.txt

For a more detailed example, have a look at the plugin configuration of
system extension `felogin` (:t3src:`felogin/Configuration/FlexForms/Login.xml`).
It shows an example of a relatively complex data structure used in a FlexForm.

More information about using FlexForms can be found in the
:ref:`relevant section of the TCA reference <t3tca:columns-flex>`.
