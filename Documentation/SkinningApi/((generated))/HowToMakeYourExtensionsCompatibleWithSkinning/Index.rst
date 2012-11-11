.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


How to make your extensions compatible with skinning
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Basically, your extensions backend modules will be skinnable by TYPO3
as long as you use the template class to create output. This is the
case in well-made extensions so by default you should expect no
problems.

However your usage of  *icons* is another story. Here you have to pass
all icon filenames and sizes to a function,
t3lib\_iconWorks::skinImg(), which will either return the input value
*or* any alternative values should an alternative icon have been
configured by a skin extension.

There are two types of icons you can encounter:

- Database record icons

- Any other icon for your interfaces.

Database record icons are not a problem. For a long time the consensus
has been that if you want to create an icon for a database record you
do like this::

   $iconImg = t3lib_iconWorks::getIconImage('sys_note',$row,$GLOBALS['BACK_PATH'],' title="This is my icon"');

As long as you keep using the t3lib\_iconWorks::getIconImage()
function the icons will be skinned.

Any other icon you might use - either from inside the extension or
e.g. typo3/gfx/ - should now be created like this::

   $iconImg = '<img'.t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'],'gfx/edit2.gif','width="11" height="12"').' title="My Icon" alt="" />';

This is contrary to the non-skinned state which would look like this::

   $iconImg = '<img src="gfx/edit2.gif" width="11" height="12" title="My Icon" alt="" />';

So as you can see it is the src, width and height attributes which are
affected!


Skinning support for local extension icons
""""""""""""""""""""""""""""""""""""""""""

If you want to add skinning support for icons found inside the
extension itself, then use this method::

   $iconImg = '<img'.t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'],t3lib_extMgm::extRelPath('templavoila').'mod1/greenled.gif','').' title="Rule applies" border="0" alt="" align="absmiddle" />';

The main thing to notice is that the relative path to the extension is
prefixed the icon name::

   t3lib_extMgm::extRelPath('templavoila').'mod1/greenled.gif'


