.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _syntax-highlighting-debugging:

Syntax highlighting and debugging
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Syntax highlighting of TypoScript code is done by various analysis
applications in TYPO3 like the Template Analyzer for TypoScript
Templates or the User Admin module or Page TSconfig function in the
Info module. These typically allow you to view the TypoScript in each
context highlighted with syntax.

Here is an example from Page TSconfig as you can view it in the Info
module:

.. figure:: ../../Images/DetailsTSconfigHighlighting.png
   :alt: An extract from the Page TSconfig field as seen in the Info module.

In the extension "extdeveval" you will also find a tool, "Code
highlighting", which can analyze TypoScript code ad hoc. This is what
you get, when you just press the TypoScript button:

.. figure:: ../../Images/DetailsExtdeveval1.png
   :alt: The interface of extdeveval with some TypoScript code and a few
         buttons.

There are various modes of display:

.. figure:: ../../Images/DetailsExtdevevalModes.png
   :alt: Some of the possible modes in extdeveval.

The analytic mode (displayed above) colors all parts of the syntax:

- **Light blue** background: Object and property names

- **Yellow** background: Values

- **Olive green** background: Whitespace

- **Brown** background: Operators

Another mode is the "Block mode", which simply indents the TypoScript
code:

.. figure:: ../../Images/DetailsExtdeveval2.png
   :alt: The interface of extdeveval with some more TypoScript code and a
         few buttons.

Finally you will be warned if syntax errors are found and ignored data
will also be highlighted in green:

.. figure:: ../../Images/DetailsSyntaxErrorsIgnoredData.png
   :alt: Extdeveval showing some syntax errors and some notes concerning
         ignored data.


.. _debugging:

Debugging
"""""""""

Debugging TypoScript for syntax errors can be done with this tool and
any other place where the syntax highlighter is used. But this will
only tell you if something is *syntactically* wrong with the code -
whether you combine objects and properties *semantically* correctly
depends on the context and cannot be told by the TypoScript parser
itself.

The Admin Panel in the TYPO3 Frontend is another possibility to debug
TypoScript; use its section "TypoScript"! It shows you selected
rendered (configuration) values, SQL queries, error messages and more.

TypoScript itself offers a number of debug functions:

- stdWrap comes with the properties debug and debugFunc: debug
  prints content with htmlspecialchars() and <pre></pre> tags.
  debugFunc prints the content using the debug() function. Set to
  value "2", the content will be printed in a table - looks nicer.

- GMENU, TMENU, IMGMENU come with the property debugItemConf. If set
  to 1, it outputs the configuration arrays for each menu item, using
  the debug() function. Useful to debug optionSplit things and such.

The TYPO3 system extension "t3editor" offers advanced functions, which
can also be useful for debugging. Its auto-completion functionality
for example only offers properties to be chosen, which in fact are
semantically allowed at a certain place. Currently t3editor is
available when editing the Setup field of a TypoScript template – not
for Page TSconfig or User TSconfig (writing December 2015).

The Template Analyzer in the Template module is similar to the
Object Browser, but it gives you valuable insights where exactly
in your setup the errors (or warnings) that have been found are
located. It allows you to view the complete TS listing, including
conditions.

