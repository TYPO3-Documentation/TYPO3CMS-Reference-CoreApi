.. include:: /Includes.rst.txt
.. index::
    TypoScript; Identifier
.. _typoscript-syntax-basics:
.. _typoscript-syntax-syntax-object-path:

===========
Identifiers
===========

TypoScript is line based. Each line normally contains three parts:

.. code-block:: text

   [Identifier] [Operator] [Value]


In this example we have the identifier :typoscript:`myIdentifier` with the sub identifier
:typoscript:`mySubIdentifier`, the assignment operator :typoscript:`=` and the value :typoscript:`myValue`.

.. include:: /CodeSnippets/TypoScriptSyntax/Identifiers1.rst.txt

The identifier path (in above example :typoscript:`myIdentifier.mySubIdentifier`) is
a dotted path of single identifiers, and the first block of non-whitespace characters
on a line until an operator, a curly open brace, or a whitespace. The dot (:typoscript:`.`)
is used to separate single identifiers, creating a hierarchy.

When a dot is part of a single identifier name (this may, for instance, sometimes happen when configuring
FlexForm details), it must be quoted with a backlash. The example below results in the
identifier :typoscript:`myIdentifier` with the sub identifier :typoscript:`my.identifier.with.dots`
having the assigned value :typoscript:`myValue`:

.. include:: /CodeSnippets/TypoScriptSyntax/Identifiers2.rst.txt
