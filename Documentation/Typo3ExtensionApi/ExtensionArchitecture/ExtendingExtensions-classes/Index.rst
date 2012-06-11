

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


Extending “extensions-classes”
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

A rather exotic thing to do but nevertheless...

If you are programming extensions yourself you should as a standard
procedure include the “class extension code” in the bottom of the
class file:

::

   if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/class.cool_shop.php"])      {
           include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/class.cool_shop.php"]);
   }

Normally the key used as example here (“ext/class.cool\_shop.php”)
would be the full path to the script relative to the PATH\_site
constant. However because modules are required to work from both
typo3/sysext/, typo3/ext/  *and* typo3conf/ext/ it is policy that any
path before “ext/” is omitted.

