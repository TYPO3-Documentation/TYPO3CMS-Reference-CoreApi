.. include:: ../../Includes.txt


.. _rte-backend:

======================================
Rich Text Editors in the TYPO3 backend
======================================


.. _rte-backend-introduction:

Introduction
============

When you configure a table in :code:`$TCA` and add a field of the type "text"
which is edited by a :code:`<textarea>`, you can choose to use a Rich Text
Editor (RTE) instead of the simple form field. A RTE enables the users
to use visual formatting aids to create bold, italic, paragraphs,
tables, etc.

.. figure:: ../../Images/RteBackend.png
   :alt: A RTE in the TYPO3 BE

   The rtehtmlarea RTE activated in the TYPO3 backend

For full details about setting up a field to use a RTE, please refer to the
:ref:`t3tca:special-configuration-options` chapter in the TCA Reference.

The short story is that it's enough to add the key :code:`defaultExtras`
to the configuration of the column with the string :code:`richtext[]` as value:

.. code-block:: php
   :emphasize-lines: 9,9

   'poem' => array(
       'exclude' => 0,
      'label' => 'LLL:EXT:examples/locallang_db.xml:tx_examples_haiku.poem',
      'config' => array(
         'type' => 'text',
         'cols' => 40,
         'rows' => 6
      ),
      'defaultExtras' => 'richtext[]'
   ),

This works for FlexForms too.

.. important::

   Don't forget to enable Rich Text Editor in the back end, in User Settings -> Edit and Advanced functions,
   check "Enable Rich Text Editor", if not already done.


Tip: How to enable a "full options RTE"
=======================================

Origin: `DocIssue #94 <https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/94>`_

Tested for 7.6, probably valid since 7.0

The description in the issue says:

A full options RTE
------------------
The doc only gives one example for rte using :php:`'defaultExtras' => 'richtext[]'`.
Note that it is possible to get a "full options RTE" by writing
:php:`'defaultExtras' => 'richtext[*]'`.
It would be very useful to describe in more detail more forms that can be used here.

Bugfix for wrong file links in the frontend
-------------------------------------------

Symptom: The RTE renders file links in the frontend like `file:1234`.

Cure: This could be fixed by writing :php:`'defaultExtras' => 'richtext[]:rte_transform[mode=ts_links]'`.


Main contents
=============

.. toctree::
   :hidden:

   PlugRte/Index

