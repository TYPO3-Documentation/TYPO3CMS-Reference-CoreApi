

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


Appendix A – What is TypoScript?
--------------------------------

People are often confused about what TypoScript (TS) is, where it can
be used and have a tendency to think of it as something complex. This
chapter has been written in the hope of clarifying these issues.

First let's start with a basic truth:

- TypoScript is a  *syntax* for defining information in a hierarchical
  structure using simple ASCII text content.

This means that:

- TypoScript itself does not "do" anything - it just contains
  information.

- TypoScript is  *only* transformed into function when it is passed to a
  program which is designed to act according to the information in a
  TypoScript information structure.

So strictly speaking TypoScript has no function in itself, only when
used in a certain context. Since the context is almost always to
*configure* something you can often understand TypoScript as
*parameters* (or function arguments) passed to a functionwhich acts
accordingly (e.g. "background\_color = red"). And on the contrary you
will probably never see TypoScript used to store information like a
database of addresses - you would use XML or SQL for that.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   PhpArrays/Index
   TyposcriptSyntaxObjectPathsObjectsAndProperties/Index

