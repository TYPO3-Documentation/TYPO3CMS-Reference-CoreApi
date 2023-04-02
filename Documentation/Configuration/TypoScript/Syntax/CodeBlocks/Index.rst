.. include:: /Includes.rst.txt
.. index::
   TypoScript; Operator "{ }"
   TypoScript; Code blocks
.. _typoscript-syntax-syntax-code-blocks:
.. _typoscript-syntax-syntax-curly-brackets:

===========
Code blocks
===========

Curly braces can be used to structure identifier paths in a more efficient way:
Without repeating upper parts of a path in each line. This allows nesting.

Example without braces:

.. include:: /CodeSnippets/TypoScriptSyntax/CodeBlock1.rst.txt

This can be written as:

.. include:: /CodeSnippets/TypoScriptSyntax/CodeBlock2.rst.txt

Curly braces can be nested to further improve readability. This is also
the same as above:

.. include:: /CodeSnippets/TypoScriptSyntax/CodeBlock3.rst.txt

Some rules apply during parsing:

- Everything on the same line after the opening :typoscript:`{` and closing
  :typoscript:`}` brace is considered a comment, even if the comment markers
  :typoscript:`#`, :typoscript:`//` and :typoscript:`/* ... */` are missing.

- The closing brace :typoscript:`}` must be on a single line in order to close a block.
  The following construct is invalid, the closing brace is interpreted as part of
  the value, so the TypoScript and TSconfig backend modules will mumble with a
  "missing closing brace" warning:

  .. include:: /CodeSnippets/TypoScriptSyntax/CodeBlockInvalidClosingBrace.rst.txt

- Conditions can not be placed within blocks, they are always "global" level
  and stop any brace nesting. The following construct is invalid, the TypoScript and
  TSconfig backend modules will mumble with a "missing closing brace" warning:

  .. include:: /CodeSnippets/TypoScriptSyntax/CodeBlockInvalidCondition.rst.txt

- Nesting is per-file / per-text-snippet: It does not "swap" into included files. This
  was the case with the old TypoScript parser. It has been a nasty side-effect, leading
  to hard to debug problems. File includes with :typoscript:`@import` and
  :typoscript:`<INCLUDE_TYPOSCRIPT:` within curly braces are not relative (anymore).
  A construct like this is invalid, the TypoScript and TSconfig backend modules will mumble
  with a "missing closing brace" warning:

  .. include:: /CodeSnippets/TypoScriptSyntax/CodeBlockInvalidImport.rst.txt
