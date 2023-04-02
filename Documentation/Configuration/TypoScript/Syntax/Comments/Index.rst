.. include:: /Includes.rst.txt
.. index::
   TypoScript; Comments
   TypoScript; Operator "//"
   TypoScript; Operator "#"
   TypoScript; Single line comments
   TypoScript; Operator "/*"
   TypoScript; Comment blocks
.. _typoscript-syntax-syntax-comments:
.. _typoscript-syntax-syntax-comment-blocks:

========
Comments
========

TypoScript supports single line comments as well as multiline comment blocks.

.. note::
    ..  versionchanged:: 12.0

    Comment handling has been relaxed significantly with the rewritten TypoScript
    parser in TYPO3 v12. The parser is much less picky detecting comments, they
    can be placed almost everywhere since v12, :typoscript:`*/` no longer needs
    to be on a single line, and comments are auto-closed at the end of a single
    text snippets.

:typoscript:`//` and :typoscript:`#` indicate a comment. Everything until the end
of the line will be ignored by the parser. :typoscript:`/*` indicates a multiline
comment start, :typoscript:`*/` stops it.

When using :typoscript:`//`, :typoscript:`#` and :typoscript:`/*` after an assignment
:typoscript:`=`, this is *not* considered a comment, but part of the value! Same is
true for multiline assignments.

Some examples:

.. include:: /CodeSnippets/TypoScriptSyntax/Comments.rst.txt
