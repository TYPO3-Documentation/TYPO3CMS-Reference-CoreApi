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


Using custom permission options
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

TYPO3 (3.7.0+) offers extension developers to register their own
permission options to be automatically managed by TYPO3s user group
access lists. The options can be grouped in categories. A custom
permission option is always a checkbox (on/off). The scope of such
options is for use in the backend of TYPO3 only.


Registering a header and options
""""""""""""""""""""""""""""""""

You configure options in the global variable
$TYPO3\_CONF\_VARS['BE']['customPermOptions']. You can read the
comment inside “config\_default.php” regarding the syntax of the
array.

This example shows how three options are registered under a new
category:

::

   $TYPO3_CONF_VARS['BE']['customPermOptions'] = array(
               'tx_coreunittest_cat1' => array(
                   'header' => '[Core Unittest] Category 1',
                   'items' => array(
                       'key1' => array('Key 1 header'),
                       'key2' => array('Key 2 header'),
                       'key3' => array('Key 3 header'),
                   )
               )
           );

The result is that these options appear in the group access lists like
this:

|img-36| You can also add icons, a description and use references to
locallang values. Such a detailed configuration could look like this
(also just an example):

::

   ...
   'tx_coreunittest_cat2' => array(
       'header' => 'LLL:EXT:coreunittest/locallang_test.php:test_header',
       'items' => array(
           'keyA' => array('Key a header', 'icon_ok.gif', 'This is a description....'),
           'keyB' => array('LLL:EXT:coreunittest/locallang_test.php:test_item', '../typo3/gfx/icon_ok2.gif', 'LLL:EXT:coreunittest/locallang_test.php:test_description'),
           'key3' => array('Key 3 header', 'EXT:coreunittest/ext_icon.gif'),
       )
   )
   ...


Evaluating the options
""""""""""""""""""""""

Checking if a custom permission option is set you simply call this API
function in the user object:

::

   $BE_USER->check('custom_options', $catKey . ':' . $itemKey);

$catKey is the category in which the option resides. From the example
above this would be “tx\_coreunittest\_cat1”

$itemKey is the key of the item in the category you are evaluating.
From the example above this could be “key1”, “key2” or “key3”
depending on which one of them you want to evaluated.

The function returns true if the option is set, otherwise false.


Keys in the array
"""""""""""""""""

It is good practice to use the extension keys prefixed with “tx\_” on
the first level of the array. This will help to make sure you do not
pick a key which someone else picked as well!

Also you should never pick a key containing any of the characters
“,:\|” since they are reserved delimiter characters.

