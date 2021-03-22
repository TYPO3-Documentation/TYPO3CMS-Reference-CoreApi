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
         <TCEforms>
   :Description:
         Contains details about visual representation of sheets. If there is
         only a single sheet, applies to implicit single sheet.
   :Child elements:
         <sheetTitle>

         <displayCond>


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

         - "array" means that the object simply contains a collection of other
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
         objects to create in the form. For TemplaVoila it will select a
         "container" element for another set of elements inside. This is quite
         fuzzy unless you understand the contexts.


.. _t3ds-elements-example:

Example
=======

Below is the (truncated) structure for the plugin options of
system extension "felogin". It shows an example of relative complex
data structure used in a FlexForm. More information about such usage
of FlexForms can be found in the :ref:`relevant section of the TCA reference <t3tca:columns-flex>`.

.. code-block:: xml

   <T3DataStructure>
      <sheets>
         <sDEF>
            <ROOT>
               <TCEforms>
                  <sheetTitle>LLL:EXT:felogin/locallang_db.xml:tt_content.pi_flexform.sheet_general</sheetTitle>
               </TCEforms>
               <type>array</type>
               <el>
                  <showForgotPassword>
                     <TCEforms>
                        <label>LLL:EXT:felogin/locallang_db.xml:tt_content.pi_flexform.show_forgot_password</label>
                        <config>
                           <type>check</type>
                           <items type="array">
                              <numIndex index="1" type="array">
                                 <numIndex index="0">LLL:EXT:core/Resources/Private/Language/locallang_core.xml:labels.enabled</numIndex>
                                 <numIndex index="1">1</numIndex>
                              </numIndex>
                           </items>
                        </config>
                     </TCEforms>
                  </showForgotPassword>
                  <showPermaLogin>
                     <TCEforms>
                        <label>LLL:EXT:felogin/locallang_db.xml:tt_content.pi_flexform.show_permalogin</label>
                        <config>
                           <default>1</default>
                           <type>check</type>
                           <items type="array">
                              <numIndex index="1" type="array">
                                 <numIndex index="0">LLL:EXT:core/Resources/Private/Language/locallang_core.xml:labels.enabled</numIndex>
                                 <numIndex index="1">1</numIndex>
                              </numIndex>
                           </items>
                        </config>
                     </TCEforms>
                  </showPermaLogin>
                  // ...
               </el>
            </ROOT>
         </sDEF>
         <s_redirect>
            <ROOT>
               <TCEforms>
                  <sheetTitle>LLL:EXT:felogin/locallang_db.xml:tt_content.pi_flexform.sheet_redirect</sheetTitle>
               </TCEforms>
               <type>array</type>
               <el>
                  <redirectMode>
                     <TCEforms>
                        <label>LLL:EXT:felogin/locallang_db.xml:tt_content.pi_flexform.redirectMode</label>
                        <config>
                           <type>select</type>
                           <items type="array">
                              <numIndex index="0" type="array">
                                 <numIndex index="0">LLL:EXT:felogin/locallang_db.xml:tt_content.pi_flexform.redirectMode.I.0</numIndex>
                                 <numIndex index="1">groupLogin</numIndex>
                              </numIndex>
                              <numIndex index="1" type="array">
                                 <numIndex index="0">LLL:EXT:felogin/locallang_db.xml:tt_content.pi_flexform.redirectMode.I.1</numIndex>
                                 <numIndex index="1">userLogin</numIndex>
                              </numIndex>
                              // ...
                           </items>
                           <size>8</size>
                           <minitems>0</minitems>
                           <maxitems>8</maxitems>
                        </config>
                     </TCEforms>
                  </redirectMode>
               </el>
            </ROOT>
         </s_redirect>
         <s_messages>
            // ...
         </s_messages>
      </sheets>
   </T3DataStructure>
