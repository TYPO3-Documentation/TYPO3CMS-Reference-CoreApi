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


Constants
^^^^^^^^^


What are constants?
"""""""""""""""""""

Constants are values defined in the "Constants"-field of a template.
They follow the syntax of ordinary TypoScript!

**Note, reserved name:** The object or property "file" is always
interpreted as data type "resource". That means it refers to a file,
which you have to upload in the resource section of your template
record.

**Note: Toplevel "object" TSConstantEditor** cannot be used. It's
reserved for configuration of the Constant Editor module.


Example:
~~~~~~~~

Here "bgCol" is set to "red" and "file.toplogo" is set to "logo.gif".
which is found in the resource-field of the template.

::

   bgCol = red
   topimg.width = 200
   topimg.file.pic2 = fileadmin/logo2.gif
   file.toplogo = logo.gif

This could also be defined in other ways, e.g. like this:

::

   bgCol = red
   file {
     toplogo = logo.gif
   }
   topimg {
     width = 200
     file.pic2 = fileadmin/logo2.gif
   }

(The objects in bold are the reserved word "file" and the properties
are always of data type "resource".

|img-11| 
Using constants
^^^^^^^^^^^^^^^

Constants are inserted in the template-setup by performing an ordinary
str\_replace operation! You insert them in the setup field like this:

::

   {$bgCol}
   {$topimg.width}
   {$topimg.file.pic2}
   {$file.toplogo}


((generated))
"""""""""""""

Example:
~~~~~~~~

::

   page = PAGE
   page.typeNum = 0
   
   page.bodyTag = <body bgColor="{$bgCol}">
   page.10 = IMAGE
   page.10.file = {$file.toplogo}

**Only constants, which are defined** in the "Constants" field, are
substituted. So for our example to work, we again have to define the
constants from the last example in the constants field.

Remember that in the constants field you can  **reference files
without giving a file path** (like we did for logo.gif). For the
replacement to work, you must upload these files in the resources
section of the template.

Constants in included templates are also substituted as the whole
template is just one large chunk of text.

Constants are case sensitive.

You should use a systematic naming scheme for constants. Seek
inspiration in the code-examples around.

|img-12| Notice how the constants in the setup code are substituted (marked in
green). In the Object Browser, you can monitor the constants with or
without substitution. Also notice that the value "logo.gif" was
resolved to the resource "uploads/tf/logo.gif"

(Note: The "Display constants" function is not available if you select
"Crop lines".)

