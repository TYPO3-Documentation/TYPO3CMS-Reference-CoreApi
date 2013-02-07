.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _t3ds-sheet-references:

Sheet references
^^^^^^^^^^^^^^^^

If Data Structures are arranged in a collection of sheets you can
choose to store one or more sheets externally in separate files. This
is done by setting the value of the <[sheet ident]> tag to a relative
file reference instead of being a definition of the <ROOT> element.


.. _t3ds-sheet-references-example:

Example
~~~~~~~

Taking the Data Structure from the :ref:`previous example <t3ds-elements-examples-complex>`
we can now rearrange it in three files:

Main Data Structure:

.. code-block:: xml

   <T3DataStructure>
     <sheets>
           <sDEF>fileadmin/sheets/default_sheet.xml</sDEF>
       <s_welcome>fileadmin/sheets/welcome_sheet.xml</s_welcome>
     </sheets>
   </T3DataStructure>

:file:`fileadmin/sheets/default_sheet.xml`:

.. code-block:: xml

   <T3DataStructure>
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
   </T3DataStructure>

:file:`fileadmin/sheets/welcome_sheet.xml`:

.. code-block:: xml

   <T3DataStructure>
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
   </T3DataStructure>
