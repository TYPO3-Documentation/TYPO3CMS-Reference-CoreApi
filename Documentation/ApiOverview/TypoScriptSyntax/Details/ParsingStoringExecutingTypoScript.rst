.. include:: /Includes.rst.txt
.. _typoscript-syntax-parsing-storing-executing-typoscript:

===============================================
Parsing, storing and executing `TypoScript`:pn:
===============================================

.. index:: TypoScript; Parsing
.. _typoscript-syntax-parsing-typoscript:

Parsing `TypoScript`:pn:
=========================

This means that the `TypoScript`:pn: text content is transformed into a PHP
array structure by following the rules of the `TypoScript`:pn: syntax. But
still the meaning of the parsed content is not evaluated.

During parsing, syntax errors may occur when the input `TypoScript`:pn: text
content does not follow the rules of the `TypoScript`:pn: syntax. The parser
is however very forgiving in that case and it only registers an error
internally while it will continue to parse the `TypoScript`:pn: code. Syntax
errors can therefore be seen only with a tool that analyzes the syntax
- like the syntax highlighter does.

The :php:`\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser` class is used to parse
`TypoScript`:pn: content. Please see the section :ref:`typoscript-syntax-typoscript-parser-api`
in this document for details.


.. index:: TypoScript; Storage
.. _typoscript-syntax-storing-typoscript:

Storing parsed `TypoScript`:pn:
===============================

When `TypoScript`:pn: has been parsed it is stored in a *PHP array* (which
is often serialized and cached in the database afterward).

Consider the following `TypoScript`:pn::

.. code-block:: typoscript

   asdf = qwerty
   asdf {
     zxcvbnm = uiop
     backgroundColor = blue
     backgroundColor.transparency = 95%
   }

After being parsed, it will be turned into a PHP array looking like
(with the :code:`print_r()` PHP function):

.. code-block:: php

   Array
   (
     [asdf] => qwerty
     [asdf.] => Array
     (
       [zxcvbnm] => uiop
       [backgroundColor] => blue
       [backgroundColor.] => Array
       (
         [transparency] => 95%
       )
     )
   )

This is stored in the internal variable :code:`$this->setup`.

This means you could fetch the value ("blue") of the property
"backgroundColor" with the following code:

.. code-block:: php

   $this->setup['asdf.']['backgroundColor']

**One could say that `TypoScript`:pn: offers a text-based
interface for getting values into a multidimensional PHP
array from a simple text field or file.** This can be very useful if
you need to take that kind of input from users without giving them
direct access to PHP code, which is the very reason why `TypoScript`:pn: came into
existence.


.. index:: TypoScript; Execution
.. _typoscript-syntax-executing-typoscript:

Executing `TypoScript`:pn:
===========================

Since `TypoScript`:pn: itself contains only information you cannot
"execute" it. The closest you come to "executing" `TypoScript`:pn: is when
you take the PHP array with the parsed `TypoScript`:pn: structure and pass
it to a PHP function which *then* performs whatever actions according
to the values found in the array.

