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


Extension configuration options (ext\_conf\_template.txt)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In this file configuration options for an extension can be defined.
They will be accessible from the TYPO3 BE in the Extension Manager
(EM), in the Information view of the extension.

There's a specific syntax to declare these options properly, which is
similar to the one used for TypoScript constants (see “Declaring
constants for the Constant editor” in “TypoScript Syntax and In-depth
Study”). This syntax applies to the comment line that should be placed
just before the constant. Consider the following example (taken from
system extension “saltedpasswords”):

::

   # cat=basic/enable; type=boolean; label=Enable FE: Enable SaltedPasswords in the frontend
   FE.enabled = 1

First a category (cat) is defined (“basic”) with the subcategory
“enable”. Then a type is given (“boolean”) and finally a label, which
is itself split (on the colon “:”) into a title and a description. The
above example will be rendered like this in the EM:

|img-3|

The options screen displays all options from a single category. A
selector is available to switch between categories. Inside an option
screen, options are grouped by subcategory. At the bottom of the
screenshot, the label – split between header and description – is
visible. Then comes the field itself, in this case a checkbox, because
the option's type is “boolean”.

