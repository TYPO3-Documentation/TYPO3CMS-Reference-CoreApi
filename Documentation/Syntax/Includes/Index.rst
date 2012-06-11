

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


Includes
^^^^^^^^

You can also add include-instructions in TypoScript code. Availability
depends on the context, but it works with TypoScript templates, Page
TSconfig and User TSconfig.

An include-instruction looks like this:

::

   <INCLUDE_TYPOSCRIPT: source="FILE: fileadmin/html/mainmenu_typoscript.txt">

- It must have its own line in the TypoScript template, otherwise it is
  not recognized.

- It is processed BEFORE any parsing of TypoScript (contrary to
  conditions) and therefore does not care about the nesting of
  confinements within the TypoScript code.

The "source" parameter points to the source of the included content.
The string before the first ":" (in the example it is the word "FILE")
will determine which source the content is coming from. This is the
only option available:


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Option
         Option
   
   Description
         Description


.. container:: table-row

   Option
         FILE
   
   Description
         A reference to a file relative to PATH\_site. Cannot contain ".."
         (double periods, back path). Until TYPO3 4.5 had to be less than 100
         KB; in newer versions this limitation was dropped.
         
         If you prefix the relative path with such as
         "EXT:myext/directory/file.txt" then the file included will be searched
         for in the extension directory of extension "myext", subdirectory
         "directory/file.txt".


.. ###### END~OF~TABLE ######

