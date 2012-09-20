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


A few examples of extending the backend classes
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The concept of extending classes in the backend can come in handy in
many cases. First of all it's a brilliant way to make your own project
specific extensions to TYPO3 without spoiling the compatibility with
the distribution! This is a very important point! Stated another way:
By making an "XCLASS extension" you can change one method in a TYPO3
class and next time you update TYPO3, your method is still there - but
all the other TYPO3 code has been updated! Great!

Also for development and experimental situations is great. Generally
the concept offers you quite a lot of freedom, because you are
seriously able to take action if you need something solved here and
now which cannot be fixed in the main distribution at the moment.

Anyway, here's a few simple examples:

1) Say you wish to have the backend user time out after 30 seconds
instead of the default 6000.

#. In your extension's (named "test") ext\_localconf.php fiel, insert:$TY
   PO3\_CONF\_VARS['BE']['XCLASS']['t3lib/class.t3lib\_beuserauth.php']=
   t3lib\_extMgm::extPath('test') .
   'class.ux\_myBackendUserExtension.php';

#. Create the file "class.ux\_myBackendUserExtension.php" in your
   extension's folder and put this content in:

::

   <?php

   class ux_t3lib_beUserAuth extends t3lib_beUserAuth {
       var $auth_timeout_field = 30;
   }
   ?>

Of course you need to know why it's the variable
:code:`auth\_timeout\_field` which must be set, but you are a bright
person, so of course you go directly to the file
t3lib/class.t3lib\_beuserauth.php, open it and find that :code:`var`
:code:`$auth\_timeout\_field` :code:`=6000;` there!

You could also easily insert an IP-filter (which is already present
though...). Here you have to take a little adventure a bit further. As
you see in "class.t3lib\_beuserauth.php" extends
"t3lib\_userAuthGroup" which extends "t3lib\_userAuth" the method
start() is the place where the users are authenticated. This could
quickly be exploited to make this IP filter for the backend:

::

   <?php

   class ux_t3lib_beUserAuth extends t3lib_beUserAuth {
       var $auth_timeout_field = 30;

       function start() {
           if (!t3lib_div::cmpIP(getenv('REMOTE_ADDR'), '192.168.*.*'))    {
               die('Wrong IP, you cannot be authenticated!');
           } else {
               return parent::start();
           }
       }
   }
   ?>

So now only users with client IP numbers in the 192.168.\*.\* series
will gain access to the backend. If that is the case, notice how the
parent start() method is called and any result is returned. Thus your
overriding method is a wrapped for the original. Brilliant, right!

2) Here's another one (from the "examples" extension, file
"xclasses/class.tx\_examples\_tceforms.php"):

::

   function formWidth($size = 48, $textarea = FALSE) {
           $size = round($size * 1.5);
           return parent::formWidth($size, $textarea);
   }

   function printPalette($palArr) {
                   // Change all field labels in the palette to uppercase
           foreach ($palArr as $key => $palette) {
                   $palArr[$key]['NAME'] = strtoupper($palArr[$key]['NAME']);
           }
           return parent::printPalette($palArr);
   }

... and configured in ext\_localconf.php as this:

::

   $TYPO3_CONF_VARS['BE']['XCLASS']['t3lib/class.t3lib_tceforms.php'] = t3lib_extMgm::extPath($_EXTKEY, 'xclasses/class.tx_examples_tceforms.php');

What is the result? A typical part of the backend form for a page will
look like this:

|img-17| But the extension does two things: 1) textarea form fields
have their width multiplied with 1.5 so they are wider (other field
types are unaffected due to different rendering mechanisms), 2) the
titles of the palette-fields are converted for uppercase. The result
looks like this:

|img-18| So as you see you can do really stupid details - in fact
almost any extension.

