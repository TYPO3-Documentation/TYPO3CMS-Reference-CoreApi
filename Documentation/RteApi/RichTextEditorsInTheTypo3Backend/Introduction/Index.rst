.. include:: Images.txt

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


Introduction
^^^^^^^^^^^^

When you configure a table in $TCA and add a field of the type “text”
which is edited by a <textarea> you can choose to use a Rich Text
Editor (RTE) instead of the <textarea> field. A RTE enables the users
to use visual formatting aids to create bold, italic, paragraphs,
tables etc. In other words, it gives normal text processing features
in the web browser.

|img-38| It is not within the scope of this chapter to describe how
you set up a text field to use an RTE. As was discussed before, the
quickest way is to add the key “defaultExtras” to the configuration of
the column and add the string “richtext[]” as value:

::

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

