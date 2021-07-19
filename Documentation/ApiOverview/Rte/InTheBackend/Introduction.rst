.. include:: /Includes.rst.txt
.. index::
   pair: Rich text editor; Backend
   pair: Rich text editor; TCA
.. _rte-backend-introduction:

============
Introduction
============

When you configure a table in :php:`$TCA` and add a field of the type "text"
which is edited by a :code:`<textarea>`, you can choose to use a Rich Text
Editor (RTE) instead of the simple form field. An RTE enables the users
to use visual formatting aids to create bold, italic, paragraphs,
tables, etc.

.. figure:: ../Images/RteBackend.png
   :alt: An RTE in the TYPO3 BE

   The rtehtmlarea RTE activated in the TYPO3 backend

For full details about setting up a field to use an RTE, please refer to the
chapter labeled 'special-configuration-options' in older versions of the
TCA Reference.

The short story is that it's enough to set the key :code:`enableRichtext` to true.

.. code-block:: php
   :emphasize-lines: 8

   'poem' => array(
       'exclude' => 0,
       'label' => 'LLL:EXT:examples/locallang_db.xml:tx_examples_haiku.poem',
       'config' => array(
           'type' => 'text',
           'cols' => 40,
           'rows' => 6,
           'enableRichtext' => true
       ),
   ),

This works for FlexForms too:

.. code-block:: xml
   :emphasize-lines: 9

   <poem>
       <TCEforms>
           <exclude>0</exclude>
           <label>LLL:EXT:examples/locallang_db.xml:tx_examples_haiku.poem</label>
           <config>
               <type>text</type>
               <cols>40<cols>
               <rows>6</rows>
               <enableRichtext>true</enableRichtext>
           </config>
       <TCEforms>
   </poem>

.. important::

   Don't forget to enable Rich Text Editor in the back end,
   in User Settings -> Edit and Advanced functions,
   check "Enable Rich Text Editor", if not already done.

