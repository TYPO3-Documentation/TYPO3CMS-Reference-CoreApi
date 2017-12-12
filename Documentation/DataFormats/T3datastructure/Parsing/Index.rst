.. include:: ../../../Includes.txt


.. _t3ds-parsing:

Parsing a Data Structure
^^^^^^^^^^^^^^^^^^^^^^^^

You can convert a Data Structure XML document into a PHP array by using the
function :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::xml2array()`.
The reverse transformation is achieved using
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::array2xml()`.

If the Data Structure uses referenced sheets, for example

.. code-block:: xml

   <T3DataStructure>
     <sheets>
           <sDEF>fileadmin/sheets/default_sheet.xml</sDEF>
       <s_welcome>fileadmin/sheets/welcome_sheet.xml</s_welcome>
     </sheets>
   </T3DataStructure>

Additional operations must be performed to resolve the sheet's content. See
class :php:`FlexFormTools`.



