.. include:: /Includes.rst.txt
.. index:: TypoScript; Syntax
.. _typoscript-syntax-typoscript-syntax:

=================
TypoScript syntax
=================

TypoScript is parsed in a very simple way; line by line. This means
that abstractly said each line normally contains three parts based on
this formula:

.. code-block:: text

   [Object Path] [Operator] [Value]


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/General.rst.txt

In this example we have the object :code:`myObject` with the property :code:`myProperty`
and a value :code:`value 2`.


.. index:: TypoScript; Object path
.. _typoscript-syntax-syntax-object-path:

Object path
===========

The object path (in this case :code:`myObject.myProperty`) is like the
variable name in a programming language. The object path is the first
block of non-whitespace characters on a line until one of the
characters :code:`=<>{(` or a white space is found. The dot (:code:`.`) is used
to separate objects and properties from each other creating a hierarchy.

**Use only A-Z, a-z, 0-9, "-", "\_" and periods (.) for object paths!**

Dots in the object path can be escaped using a backslash.

**Escaping example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/Escaping.rst.txt

This will result in an object named :code:`my.escaped.key` with the value "test".
Here we do **not** have three hierarchically structured objects :code:`my`,
:code:`escaped` and :code:`key`.


.. index:: TypoScript; Operator
.. _typoscript-syntax-syntax-operator:

Operator
========

The operator (in the example it is :code:`=`) can be one of the characters
:code:`=<>{(`. The various operators are described below.


.. index::
   TypoScript; Operator "="
   TypoScript; Value assignment
.. _typoscript-syntax-syntax-equal-operator:
.. _typoscript-syntax-syntax-value-assignment:

Value assignment: The "=" operator
----------------------------------

This assigns a value to an object path.


**Rules:**

Everything after the :code:`=` sign and *up to the end of the line* is
considered to be the value. In other words: You don't need to quote
anything!

Be aware that the value will be trimmed, which means stripped of
whitespace at both ends.


.. index::
   TypoScript; Operator ":="
   TypoScript; Value modifications
.. _typoscript-syntax-syntax-colon-equal-operator:
.. _typoscript-syntax-syntax-value-modification:

Value modifications: The ":=" operator
--------------------------------------

This operator assigns a value to an object path by calling a
predefined function which modifies the existing value of the current
object path in different ways.

This is very useful when a value should be modified without completely
redefining it again.


**Rules:**

The portion after the :code:`:=` operator and *to the end of the line* is
split in two parts: A function and a value. The function is specified
right next to the operator (trimmed) and holding the value in parentheses
(not trimmed).

This is the list of predefined functions:

prependString
   Adds a string to the beginning of the existing
   value.

appendString
   Adds a string to the end of the existing value.

removeString
   Removes a string from the existing value.

replaceString
   Replaces old with new value. Separate these using
   :code:`|`.

addToList
   Adds a comma-separated list of values to the end of a
   string value. There is no check for duplicate values, and the list is
   not sorted in any way.

removeFromList
   Removes a comma-separated list of values from an
   existing comma-separated list of values.

uniqueList
   Removes duplicate entries from a comma-separated list
   of values.

reverseList
   Reverses the order of entries in a comma-separated
   list of values.

sortList
   Sorts the entries in a comma-separated list of values.
   Optional parameters are:

   ascending
      Sort the items in ascending order: First numbers
      from small to big, then letters in alphabetical order. This is the
      default method.

   descending
      Sort the items in descending order: First letters
      in descending order, then numbers from big to small.
   numeric
      Apply numeric sorting: Numbers from small to big,
      letters sorted after "0".

   Multiple parameters are separated by comma.


..  todo:
    Use new PSR-14 event "EvaluateModifierFunctionEvent":
    https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Feature-98016-PSR-14EvaluateModifierFunctionEvent.html
    The hook was removed in v12.0:
    https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Breaking-98016-RemovedTypoScriptFunctionHook.html

There is a hook inside class :php:`\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser`
which can be used to define more such functions.


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ValueModification.rst.txt

produces the same result as:

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ValueModification2.rst.txt


.. index::
   TypoScript; Operator "{ }"
   TypoScript; Code blocks
.. _typoscript-syntax-syntax-code-blocks:
.. _typoscript-syntax-syntax-curly-brackets:

Code blocks: The { } signs
--------------------------

Opening and closing curly braces are used to assign many object
properties in a simple way at once. It's called a block or nesting of
properties.


**Rules:**

-  Everything on the same line as the opening brace (:code:`{`), but that comes
   *after* it is ignored.

-  The :code:`}` sign *must* be the first non-space character on a line in
   order to close the block. Everything on the same line, but after :code:`}`
   is ignored.

-  Blocks can be nested. This is actually recommended for **improved
   readability**.

.. attention::

   You cannot use conditions inside of braces (except the
   :code:`[GLOBAL]` condition which will be detected and reset the brace-level to
   zero)

.. note::

  Excessive end braces are ignored, but generate warnings in
  the TypoScript parser.


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/CodeBlock.rst.txt

could also be written as:

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/CodeBlock2.rst.txt


.. index::
   TypoScript; Operator "( )"
   TypoScript; Multi-line values
.. _typoscript-syntax-syntax-round-brackets:
.. _typoscript-syntax-syntax-multiline-values:

Multi-line values: The ( ) signs
--------------------------------

Opening and closing parenthesis are used to assign a *multi-line
value* . With this method you can define values which span several
lines and thus include line breaks.

.. attention::

   You cannot use multi-line values in constants. They are only available in
   the setup part of TypoScript.

**Rules:**

The end-parenthesis is extremely important. If it is not
found, the parser considers the following lines to be part of the
value and does not return to parsing TypoScript. This includes the
:code:`[GLOBAL]` condition which will not save you in this case! So don't miss
it!


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/MultiLine.rst.txt


.. index::
   TypoScript; Operator "<"
   TypoScript; Object copying
.. _typoscript-syntax-syntax-smaller-than-operator:
.. _typoscript-syntax-syntax-object-copying:

Object copying: The "<" sign
----------------------------

The :code:`<` sign is used to copy one object path to another. The whole
object is copied - both value and properties - and it overrides any
old objects and values at that position.


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ObjectCopying.rst.txt

The result of the above TypoScript is two independent sets of
objects/properties which are exactly the same (duplicates). They are
*not* references to each other but actual copies:

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/SyntaxCopying1.rst.txt

Another example with a copy within a code block:

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ObjectCopying2.rst.txt

Here also a copy is made, although inside the :code:`pageObj` object. Note
that the copied object is referred to with its full path
(:code:`pageObj.10`). When **copying on the same level**, you can
refer to the copied object's name, **prepended by a dot**.

The following produces the same result as above:

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ObjectCopying3.rst.txt

which – in tree view – translates to:

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/SyntaxCopying2.rst.txt

.. attention::

   When the original object is changed after copying, the
   copy does not change! Take a look at the following code:

   .. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ObjectCopying4.rst.txt

   The value of the :code:`stdWrap.wrap` property of :code:`anotherObject`
   is :code:`<p>|</p>`. It is **not** :code:`<h1>|<h1>` because this change
   happens **after** the copying. This example may seem trivial, but
   it's easy to loose the oversight in larger pieces of TypoScript.

.. note::

  If the copy operator does not give you any result, then the reason for this behaviour can
  be a wrong initialization order of the objects. The original object shall be copied, but it has not been
  assigned the intended value at this moment. Try to use the equal smaller "=<" sign instead. Then TYPO3
  will make the intended object still available after its initialization.

.. index::
   TypoScript; Operator "=<"
   TypoScript; References
.. _typoscript-syntax-syntax-equal-smaller-than-operator:
.. _typoscript-syntax-syntax-object-referencing:

Object references: the equal smaller "=<" sign
----------------------------------------------

**In the context of TypoScript Templates** it is possible to create
references from one object to another. References mean that multiple
positions in an object tree can use the same object at another
position without making an actual copy of the object but by
pointing to the objects full object path.

The obvious advantage is that a **change of code to the original
object affects all references**. It avoids the risk mentioned above
with the copy operator to forget that a change at a later point does
not affect earlier copies. On the other hand there's the reverse risk:
It is easy to forget that changing the original object will have an
impact on all references. References are very convenient, but should
be used with caution.

*Note:* Changing or adding attributes in the object holding a reference
will not change the original object that was referenced.


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ObjectReference.rst.txt

In this case, the :code:`stdWrap.wrap` property of :code:`anotherObject`
will indeed be :code:`<h1>|<h1>`. In tree view the properties
of the reference are not shown. Only the reference itself is visible:

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/SyntaxReferencing.rst.txt

Remember:

-  References are only available in TypoScript templates, not in TSconfig
   (user TSconfig or page TSconfig)

-  References are only resolved for Content Objects, otherwise references are
   not resolved. For example, you **cannot** use a
   reference :code:`< plugin.tx_example.settings.foo` to find the value of `foo`.
   The value you get will be just :code:`< plugin.tx_example.settings.foo` instead.


.. index::
   TypoScript; Operator ">"
   TypoScript; Object unsetting
.. _typoscript-syntax-syntax-bigger-than-operator:
.. _typoscript-syntax-syntax-unsetting-operator:

Object unsetting: The ">" Sign
------------------------------

This is used to unset an object and all of its properties.


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/ObjectUnsetting.rst.txt

In this last line :code:`myObject` is totally wiped out (removed).


.. index::
   TypoScript; Operator "["
   TypoScript; Conditions
.. _typoscript-syntax-syntax-square-brackets:
.. _typoscript-syntax-syntax-conditions:

Conditions: Lines starting with "["
-----------------------------------

Conditions break the parsing of TypoScript in order to evaluate the
content of the condition line. If the evaluation returns true, parsing
continues, otherwise the following TypoScript is ignored until the
next condition is found, at which point a new evaluation takes place.
The next section in this document describes conditions in more
details.


**Rules:**

Conditions apply *only* when outside of any code block (i.e. outside
of any curly braces).


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/Conditions.rst.txt

.. index::
   TypoScript; Value
.. _typoscript-syntax-syntax-value:

Value
=====

The value (in case of the above example "value 2") is whatever characters
follow the operator until the end of the line, but trimmed for whitespace
at both ends. Notice that values are *not* encapsulated in quotes! The
value starts after the operator and ends with the line break.


.. index::
   TypoScript; Comments
.. _typoscript-syntax-syntax-comments:

Comments
========

TypoScript support single line comments as well as multiline comment blocks.


.. index::
   TypoScript; Operator "//"
   TypoScript; Operator "#"
   TypoScript; Single line comments

Single line comments
--------------------

When a line starts with :code:`//` or :code:`#` it is considered to be a comment
and will be ignored.

**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/CommentsSingleLine.rst.txt

.. index::
   TypoScript; Operator "/*"
   TypoScript; Comment blocks
.. _typoscript-syntax-syntax-comment-blocks:

Comment blocks
--------------

When a line starts with :code:`/*` or :code:`*/` it defines the beginning or the
end of a comment section respectively. Anything, excluding imports,  inside a comment
section is ignored.

.. warning::
   Imports within a block comment are still resolved. This is true for both imports
   with the :typoscript:`@import` and :typoscript:`<INCLUDE_TYPOSCRIPT: source="...">`
   syntax. Always use single line comments to comment out imports.

**Rules:**

:code:`/*` and :code:`*/` **must** be the very first characters of a trimmed line in
order to be detected.

Comment blocks are not detected inside a multi-line value block (see
parenthesis operator below).


**Example:**

.. include:: /CodeSnippets/TypoScriptSyntax/Syntax/CommentsBlock.rst.txt

