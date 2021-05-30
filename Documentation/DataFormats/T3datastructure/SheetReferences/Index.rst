.. include:: /Includes.rst.txt


.. _t3ds-sheet-references:

================
Sheet References
================

If Data Structures are arranged in a collection of sheets you can
choose to store one or more sheets externally in separate files. This
is done by setting the value of the <[sheet ident]> tag to a relative
file reference instead of being a definition of the <ROOT> element.


.. _t3ds-sheet-references-example:

Example
=======

Taking the Data Structure from the :ref:`previous example <t3ds-elements-example>`
we could rearrange it in separate files:

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
   </T3DataStructure>

and the same for the other sheet :file:`welcome_sheet.xml`.
