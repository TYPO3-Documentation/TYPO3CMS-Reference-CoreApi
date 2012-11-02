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


|img-34| Support for custom tables in the Page module
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In the Web > Page module you can have listings of other records than
Content Elements and guest book items. If you want your custom table
to be listed there you can configure it using the
$TYPO3\_CONF\_VARS["EXTCONF"]['cms'] array. This is a configuration
option offered from within the Page module.

In this example the tt\_news extension is configured for listing in
the Page module. It would look like this:

|img-35| The configuration required is as simple as this, put into
(ext\_)localconf.php:

::

   $TYPO3_CONF_VARS['EXTCONF']['cms']['db_layout']['addTables']['tt_news'][0] = array(
       'fList' => 'title,short;author',
       'icon' => TRUE
   );

The "fList" key value is a list of field names separated first by
comma and then ";" (semi-colon). The comma separates table columns
while the semi-colon allows you to list more than one field to be
displayed inside a single column.

