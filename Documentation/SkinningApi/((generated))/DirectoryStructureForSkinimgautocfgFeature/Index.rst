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


Directory structure for “skinImgAutoCfg” feature
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In the example above the directory “icons/” inside the extension is
configured to contain the alternative icons which are automatically
detected.

Inside of this directory the structure must reflect the  *icon
reference* of the “skinImg” feature which would have otherwise
addressed the icon.

Looking at this screenshot makes it easy to understand. If you want to
skin the icon “gfx/closedok.gif” then just put a file with the  *same*
name (possible as “png” if “forceFileExtension” was set to “png”) in
the folder “icons/gfx/”.

If you have an extension, say, “sys\_action” and wants to skin the
Action database record icon (sys\_action.gif) simply put an
alternative file for “sys\_action.gif” into the folder
“ext/sys\_action/”

|img-41|

If you look in the “icons” folder of the “skin360” extension you can
also see that all the module icons are located there - but notice that
they are  *manually* referenced in the “skinImg” key!

