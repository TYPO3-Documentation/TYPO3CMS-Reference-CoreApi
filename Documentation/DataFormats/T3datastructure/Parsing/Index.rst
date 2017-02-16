.. include:: ../../../Includes.txt


.. _t3ds-parsing:

Parsing a Data Structure
^^^^^^^^^^^^^^^^^^^^^^^^

You can convert a Data Structure XML document into a PHP array by using the
function :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::xml2array()`.
The reverse transformation is achieved using :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::array2xml_cs()`.

If the Data Structure uses referenced sheets, for example

.. code-block:: xml

   <T3DataStructure>
     <sheets>
           <sDEF>fileadmin/sheets/default_sheet.xml</sDEF>
       <s_welcome>fileadmin/sheets/welcome_sheet.xml</s_welcome>
     </sheets>
   </T3DataStructure>

additional operations must be performed to resolve the sheets content::

   $treeDat = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($inputCode);
   $treeDat = \TYPO3\CMS\Core\Utility\GeneralUtility::resolveAllSheetsInDS($treeDat);


