

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Elements
^^^^^^^^

This is the list of elements and their nesting in the Data Structure.
This could probably be expressed by a DTD or XML schema (anyone?).
Words will have to do for now.


Elements nesting other elements (“Array” elements):
"""""""""""""""""""""""""""""""""""""""""""""""""""

All elements defined here cannot contain any string value but  *must*
contain another set of elements.

(In a PHP array this corresponds to saying that all these elements
must be arrays.)

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Element
         Element
   
   Description
         Description
   
   Child elements
         Child elements


.. container:: table-row

   Element
         <T3DataStructure>
   
   Description
         Document tag
   
   Child elements
         <meta>
         
         <ROOT>  *or* <sheets>


.. container:: table-row

   Element
         <meta>
   
   Description
         Can contain application specific meta settings
   
   Child elements


.. container:: table-row

   Element
         <ROOT>
         
         <[field name]>
   
   Description
         Defines an “object” in the Data Structure
         
         - <ROOT> is reserved as tag for the first element in the Data
           Structure.The <ROOT> element must have a <type> tag with the value
           “array” and then define other objects nested in <el> tags.
         
         - [field name] defines the objects name
   
   Child elements
         <type>
         
         <section>
         
         <el>
         
         <[application tag]>


.. container:: table-row

   Element
         <sheets>
   
   Description
         Defines a collection of “sheets” which is like a one-dimensional list
         of independent Data Structures
   
   Child elements
         <[sheet name]>


.. container:: table-row

   Element
         <TCEforms>
   
   Description
         Contains details about visual representation of sheets. If there is
         only a single sheet, applies to implicit single sheet.
   
   Child elements
         <sheetTitle> <cshFile>


.. container:: table-row

   Element
         <sheetTitle>
   
   Description
         Title of the sheet. Mandatory for any sheet except the first (which
         gets "General" in this case). Can be a plain string or a reference to
         language file using standard LLL syntax. Ignored if sheets are not
         defined for the flexform.
   
   Child elements


.. container:: table-row

   Element
         <cshFile>
   
   Description
         CSH language file for fields inside the flexform. Refer to section on
         T3locallang of this document on the format of language files and to
         section Content Sensitive Help of "Inside TYPO3" document for
         information about CSH.
   
   Child elements


.. container:: table-row

   Element
         <[sheet ident]>
   
   Description
         Defines an independent data structure starting with a <ROOT> tag.
         
         **Notice:** Alternatively it can be a plain value referring to another
         XML file which contains the <ROOT> structure. See example below.
   
   Child elements
         <ROOT>


.. container:: table-row

   Element
         <el>
   
   Description
         Contains a collection of Data Structure “objects”
   
   Child elements
         <[field name]>


.. ###### END~OF~TABLE ######


Elements containing values (“Value” elements):
""""""""""""""""""""""""""""""""""""""""""""""

All elements defined here must contain a string value and no other XML
tags whatsoever!

(In a PHP array this corresponds to saying that all these elements
must be strings or integers.)

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Element
         Element
   
   Format
         Format
   
   Description
         Description


.. container:: table-row

   Element
         <type>
   
   Format
         Keyword string:
         
         “array”, [blank] (=default)
   
   Description
         Defines the type of object.
         
         - “array” means that the object simply contains a collection of other
           objects defined inside the <el> tag on the same levelIf the value is
           “array” you can use the boolean “<section>”. See below.
         
         - Default value means that the object does not contain sub objects. The
           meaning of such an object is determined by the application using the
           data structure. For FlexForms this object would draw a form element.
         
         **Notice:** If the object was <ROOT> this tag must have the value
         “array”


.. container:: table-row

   Element
         <section>
   
   Format
         Boolean, 0/1
   
   Description
         Defines for an object of the type <array> that it must contain other
         “array” type objects. The meaning of this is application specific. For
         FlexForms it will allow the user to select between possible arrays of
         objects to create in the form. For TemplaVoila it will select a
         “container” element for another set of elements inside. This is quite
         fuzzy unless you understand the contexts.


.. ###### END~OF~TABLE ######


Example: FlexForm configuration in “mininews” extension
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Simple example of a data structure used to define a FlexForm element
in TCEforms. Notice the application specific section <TCEforms> (see
documentation for FlexForms).

::

   <T3DataStructure>
           <meta>
                   <langDisable>1</langDisable>
           </meta>
     <ROOT>
       <type>array</type>
       <el>
         <field_templateObject>
                   <TCEforms>
                           <label>LLL:EXT:mininews/locallang_db.php:tt_content.pi_flexform.select_template</label>
   
                           <config>
                                   <type>select</type>
                                   <items>
                                           <numIndex index=”0”>
                                                   <numIndex index=”0”></numIndex>
                                                   <numIndex index=”1”>0</numIndex>
                                           </numIndex>
                                   </items>
                                   <foreign_table>tx_templavoila_tmplobj</foreign_table>
                                   <foreign_table_where>
                                           AND tx_templavoila_tmplobj.pid=###STORAGE_PID### 
                                           AND tx_templavoila_tmplobj.datastructure="EXT:mininews/template_datastructure.xml" 
                                           AND tx_templavoila_tmplobj.parent=0 
                                           ORDER BY tx_templavoila_tmplobj.title
                                   </foreign_table_where>
                                   <size>1</size>
                                   <minitems>0</minitems>
                                   <maxitems>1</maxitems>
                           </config>
                   </TCEforms>
         </field_templateObject>
       </el>
     </ROOT>
   </T3DataStructure>


Example #2
~~~~~~~~~~

More complex example of a FlexForms structure, using two sheets,
“sDEF” and “s\_welcome” (snippet from “newloginbox” extension).

::

   <T3DataStructure>
     <sheets>
           <sDEF>
             <ROOT>
                   <TCEforms>
                           <sheetTitle>LLL:EXT:newloginbox/locallang_db.php:tt_content.pi_flexform.sheet_general</sheetTitle>
                   </TCEforms>
               <type>array</type>
               <el>
                 <show_forgot_password>
                           <TCEforms>
                                   <label>LLL:EXT:newloginbox/locallang_db.php:tt_content.pi_flexform.show_forgot_password</label>
                                   <config>
                                           <type>check</type>
                                   </config>
                           </TCEforms>
                 </show_forgot_password>
               </el>
             </ROOT>
       </sDEF>
       <s_welcome>
             <ROOT>
                   <TCEforms>
                           <sheetTitle>LLL:EXT:newloginbox/locallang_db.php:tt_content.pi_flexform.sheet_welcome</sheetTitle>
                   </TCEforms>
               <type>array</type>
               <el>
                 <header>
                           <TCEforms>
                                   <label>LLL:EXT:newloginbox/locallang_db.php:tt_content.pi_flexform.header</label>
                                   <config>
                                           <type>input</type>
                                           <size>30</size>
                                   </config>
                           </TCEforms>
                 </header>
                 <message>
                           <TCEforms>
                                   <label>LLL:EXT:newloginbox/locallang_db.php:tt_content.pi_flexform.message</label>
                                   <config>
                                           <type>text</type>
                                           <cols>30</cols>
                                           <rows>5</rows>
                                   </config>
                           </TCEforms>
                 </message>                  
               </el>
             </ROOT>
       </s_welcome>
     </sheets>
   </T3DataStructure>

