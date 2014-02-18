.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _using-constants:

Using constants
^^^^^^^^^^^^^^^

Constants are inserted in the template-setup by performing an ordinary
str\_replace operation! You insert them in the setup field inside curly
braces with a prepended $ sign like so::

   {$bgCol}
   {$topimg.width}
   {$topimg.file.pic2}
   {$file.toplogo}


Example:
""""""""

::

   page = PAGE
   page.typeNum = 0

   page.bodyTag = <body bgColor="{$bgCol}">
   page.10 = IMAGE
   page.10.file = {$file.toplogo}

**Only constants, which are actually defined** in the "Constants"
field, are substituted. So for our example to work, we again have to
define the constants from the last example in the constants field.

In contrast to TYPO3 versions prior to 6.0 you can **no longer**
reference files in the constants field without giving a file *path*
(except the file is located in the root directory of your TYPO3
installation). Instead you have to define file name *and path*, in our
case for logo.gif. For the replacement to work, you must upload the
file in the according folder of your TYPO3 installation.

Constants in included templates are also substituted as the whole
template is just one large chunk of text.

You should use a systematic naming scheme for constants. Seek
inspiration in the code examples around.

.. figure:: ../../Images/TSTemplatesSetup.png
   :alt: Overview of the defined setup.

Notice how the constants in the setup code are substituted (marked in
green). In the Object Browser, you can monitor the constants with or
without substitution.

(Note: The "Display constants" function is not available if you select
"Crop lines".)

