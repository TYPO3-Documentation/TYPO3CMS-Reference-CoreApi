.. include:: /Includes.rst.txt


.. _t3ds-elements:

========
Elements
========

This is the list of elements and their nesting in the Data Structure.

.. _t3ds-elements-array:

Elements Nesting Other Elements ("Array" Elements)
==================================================

All elements defined here cannot contain any string value but  *must*
contain another set of elements.

(In a PHP array this corresponds to saying that all these elements
must be arrays.)

.. t3-field-list-table::
 :header-rows: 1

 - :Element,20: Element
   :Description,60: Description
   :Child elements,20: Child elements


 - :Element:
         <T3DataStructure>
   :Description:
         Document tag
   :Child elements:
         <meta>

         <ROOT> *or* <sheets>


 - :Element:
         <meta>
   :Description:
         Can contain application specific meta settings
   :Child elements:
         (depends on application)


 - :Element:
         <ROOT>

         <[field name]>
   :Description:
         Defines an "object" in the Data Structure

         - <ROOT> is reserved as tag for the first element in the Data
           Structure.The <ROOT> element must have a <type> tag with the value
           "array" and then define other objects nested in <el> tags.

         - [field name] defines the objects name
   :Child elements:
         <type>

         <section>

         <el>

         <[application tag]>


 - :Element:
         <sheets>
   :Description:
         Defines a collection of "sheets" which is like a one-dimensional list
         of independent Data Structures
   :Child elements:
         <[sheet name]>


 - :Element:
         <sheetTitle>
   :Description:
         Title of the sheet. Mandatory for any sheet except the first (which
         gets "General" in this case). Can be a plain string or a reference to
         language file using standard LLL syntax. Ignored if sheets are not
         defined for the flexform.
   :Child elements:
         -


 - :Element:
         <displayCond>
   :Description:
         Condition that must be met in order for the sheet to be displayed.
         If the condition is not met, the sheet is hidden.

         For more details refer to the description of the "displayCond" property
         in the :ref:`TCA Reference <t3tca:columns>`.
   :Child elements:
         -


 - :Element:
         <[sheet ident]>
   :Description:
         Defines an independent data structure starting with a <ROOT> tag.

         .. note::

            Alternatively it can be a plain value referring to another
            XML file which contains the <ROOT> structure. See example later.
   :Child elements:
         <ROOT>


 - :Element:
         <el>
   :Description:
         Contains a collection of Data Structure "objects"
   :Child elements:
         <[field name]>

Elements can use the attribute :xml:`type` to define their type, for example explicitly use boolean.
An example would look like:

..  code-block:: xml

    <required type="boolean">1</required>

.. _t3ds-elements-value:

Elements Containing Values ("Value" Elements)
=============================================

All elements defined here must contain a string value and no other XML
tags whatsoever!

(In a PHP array this corresponds to saying that all these elements
must be strings or integers.)

.. t3-field-list-table::
 :header-rows: 1

 - :Element,20: Element
   :Format,20: Format
   :Description,60: Description


 - :Element:
         <type>
   :Format:
         Keyword string:

         "array", [blank] (=default)
   :Description:
         Defines the type of object.

         - "array" means that the object contains a collection of other
           objects defined inside the <el> tag on the same level. If the value is
           "array" you can use the boolean "<section>". See below.

         - Default value means that the object does not contain sub objects. The
           meaning of such an object is determined by the application using the
           data structure. For FlexForms this object would draw a form element.

         .. note::

            If the object was <ROOT> this tag must have the value "array"


 - :Element:
         <section>
   :Format:
         Boolean
   :Description:
         Defines for an object of the type <array> that it must contain other
         "array" type objects in each item of <el>. The meaning of this is application specific. For
         FlexForms it will allow the user to select between possible arrays of
         objects to create in the form. This is similar to the concept of
         :ref:`IRRE / inline TCA definitions <t3tca:columns-inline>`.

..  versionchanged:: 13.0

    The usage of available element types within FlexForm sections is
    restricted. You should only use simple TCA types like
    :php:`type => 'input'` within sections, and relations (:php:`type =>
    'group'`, :php:`type => 'inline'`, :php:`type => 'select'` and similar)
    should be avoided.
    TYPO3 v13 specifically disallows using :php:`type => 'select'` with
    a :php:`foreign_table` set, which will raise an exception.
    This does not apply for FlexForm fields outside of a :xml:`<section>`.
    Details can be found in
    :ref:`ext_core:breaking-102970-1706447911`.


.. _t3ds-elements-example:

Example
=======

Below is the structure of a basic FlexForm from the example extension
:composer:`typo3/cms-styleguide`:

..  include:: /CodeSnippets/FlexForms/Simple.rst.txt

For a more elaborate example, have a look at the plugin configuration of
system extension `felogin` (:t3src:`felogin/Configuration/FlexForms/Login.xml`).
It shows an example of relative complex data structure used in a FlexForm.

More information about such usage of FlexForms can be found in the
:ref:`relevant section of the TCA reference <t3tca:columns-flex>`.
