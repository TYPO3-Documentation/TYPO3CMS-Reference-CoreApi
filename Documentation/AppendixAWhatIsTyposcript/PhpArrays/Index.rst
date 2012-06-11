

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


PHP arrays
^^^^^^^^^^

In the scope of its use you can also understand TypoScript as a non-
strict way to enter information into a  *multidimensional array* . In
fact when TypoScript is parsed, it is  *transformed into a PHP array*
! So when would you define static information in PHP arrays? You would
do that in configuration files - but probably not to build your
address database!

This can be summarized as follows:

- When TypoScript is  *parsed* it means that the information is
  transformed into a  *PHP array* from where TYPO3 applications can
  access it.

- So the  *same* information could in factbe defined in TypoScript  *or
  directly* in PHP; but the syntax would be different for the two of
  course.

- TypoScript offers convenient features which is the reason why we don't
  just define the information directly with PHP syntax into arrays.
  These features include a relaxed handling of syntax errors, definition
  of values with less language symbols needed and the ability of using
  an object/property metaphor, etc.

