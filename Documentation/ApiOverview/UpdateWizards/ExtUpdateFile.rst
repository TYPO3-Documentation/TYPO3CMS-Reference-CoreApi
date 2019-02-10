.. include:: ../../Includes.txt

.. _update-wizards-extupdatefile:

====================
class.ext_update.php
====================

While the update wizards already provide a skeleton and integration into TYPO3
CMS, there is a file from old times. This file is placed in the extension root
and called :file:`class.ext_update.php`. For better overview it's recommended to
use the new update wizards with separate classes for each update.

If this file is found it will install a new menu item, "UPDATE", in the
Extension Manager when looking at details for the extension. When this menu item
is selected the class inside of this file (named :php:`ext_update`) will be
instantiated and the method :php:`main()` will be called and expected to return
HTML content.

Also the method :php:`access()` has to be added. This method should return a
boolean value whether or not the menu item should be shown. This feature is
meant to disable the update tool if it has already been run and doesn't need to
run again.
