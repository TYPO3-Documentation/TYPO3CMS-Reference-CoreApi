.. include:: /Includes.rst.txt
.. index:: TypoScript; Operator
.. _typoscript-syntax-syntax-operator:

=========
Operators
=========

TypoScript syntax comes with a couple of operators to assign
values, copy from other identifier paths, and to manipulate values.
Let's have a closer look at them.


.. index::
   TypoScript; Operator "="
   TypoScript; Value assignment
.. _typoscript-syntax-syntax-equal-operator:
.. _typoscript-syntax-syntax-value-assignment:

Value assignment with "="
-------------------------

This most common operator assigns a single line value to an identifier path.
Everything after the :typoscript:`=` character until the end of the line is
considered to be the value. The value is trimmed, leading and trailing whitespaces
are removed.

Values are parsed for constant references. With a value assignment like
:typoscript:`foo = someText {$someConstant} furtherText`, the parser will
look up the constant reference :typoscript:`{$someConstant}` and tries to
substitute it with a defined constant value. If such a constant does not
exist, it falls back to the string literal including the :typoscript:`{$` and
:typoscript:`}` characters.

A couple of examples:

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorAssignment.rst.txt

..  caution::
    The TypoScript parser looks for valid operators first, then parses things
    behind it. Consider this example:

    ..  code-block:: typoscript

        lib.nav.wrap =<ul id="nav">|</ul>

    This is ambiguous: The above :typoscript:`=<ul` could be interpreted both as
    an assignment :typoscript:`=` of the value :typoscript:`<ul`, or as a
    :ref:`reference <typoscript-syntax-syntax-object-referencing>`
    :typoscript:`=<` to the identifier :typoscript:`ul`.

    Before TYPO3 v12.0 the TypoScript parser interpreted this as an assignment,
    since TYPO3 v12.0 it is treated as a reference.

    The above example aims for an assignment, though, which can be achieved by
    adding a whitespace between :typoscript:`=` and :typoscript:`<`:

    ..  code-block:: typoscript

        lib.nav.wrap = <ul id="nav">|</ul>

.. index::
   TypoScript; Operator "( )"
   TypoScript; Multi-line values
.. _typoscript-syntax-syntax-round-brackets:
.. _typoscript-syntax-syntax-multiline-values:

Multiline assignment with "(" and ")"
-------------------------------------

Opening and closing parenthesis are used to assign multi-line values. This allows
defining values that span several lines and thus include line breaks.

The end parenthesis :typoscript:`)` is important: If it is not found, the parser
considers all following lines until the end of the TypoScript text snipped to be part
of the value. This includes comments, :typoscript:`[GLOBAL]` conditions and :typoscript:`@import`
file includes: They are not a syntax construct and are considered part of the value assignment.

However, the value is parsed for constants (text looking like :typoscript:`{$myIdentifier.mySubIdentifier}`:
The parser will try to substitute them to their assigned constant value. The "TypoScript" and
"Page TSconfig" backend modules may show a warning if a reference to a constant can't be resolved.
If a constant reference can't be resolved, the value falls back to its string literal.
Since multi-line values are sometimes used to output JavaScript, and JavaScript also uses a
syntax construct like :typoscript:`{$...}`, this may lead to false positive warnings in those
backend modules.

A couple of examples:

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorMultiLine.rst.txt


.. index::
   TypoScript; Operator ">"
   TypoScript; Object unsetting
.. _typoscript-syntax-syntax-bigger-than-operator:
.. _typoscript-syntax-syntax-unsetting-operator:

Unset with ">"
--------------

This can be used to unset a previously defined identifier path value, and
all of its sub identifiers:

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorUnset.rst.txt


.. index::
   TypoScript; Operator "<"
   TypoScript; Object copying
.. _typoscript-syntax-syntax-smaller-than-operator:
.. _typoscript-syntax-syntax-object-copying:

Copy with "<"
-------------

The :typoscript:`<` character is used to copy one identifier path to another.
The whole current identifier state is copied: both value and sub identifiers.
It overrides any old sub identifiers and values at that position.

The copy operator is useful to follow the
`DRY - Don't repeat yourself <https://en.wikipedia.org/wiki/Don%27t_repeat_yourself>`__
principle. It allows maintaining a configuration set at a central place, and copies are
used at further places when needed again.

The result of the below TypoScript is two independent sets which are duplicates.
They are not references to each other but actual copies:

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorCopy1.rst.txt

The copy operator is allowed within code blocks as well:

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorCopy2.rst.txt

In the above example, the copied identifier path is referred to with its full path
:typoscript:`myIdentifier.10`. When copying on the same level, it is allowed
to use a relative path, indicated by a prepended dot. The following produces
the same result as above:

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorCopy3.rst.txt

Using the copy operator creates a copy of the source path at exactly this point
in the parsing process. Changing the source afterwards does not change the
target, and changing the target afterwards does not change the source:

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorCopy4.rst.txt


.. index::
   TypoScript; Operator "=<"
   TypoScript; References
.. _typoscript-syntax-syntax-equal-smaller-than-operator:
.. _typoscript-syntax-syntax-object-referencing:

References with "=<"
--------------------

.. note::

    The reference operator :typoscript:`=<` is not a general syntax construct.
    Even though the TypoScript and TSconfig backend modules show usages of
    the operator, they are only resolved in frontend TypoScript for the
    special :typoscript:`tt_content` path: You can use :typoscript:`=<`
    in frontend TypoScript for example with
    :typoscript:`tt_content.text =< lib.contentElement`, and you are encouraged
    to do so in this special case for performance reasons, but this operator
    does not work anywhere else.

In the context of frontend TypoScript, it is possible to create
references from one identifier path to another within the :typoscript:`tt_content`
path. References mean that multiple positions can copy the same source
identifier path without making an actual copy. This allows changes to the
source identifier afterwards, which changes the targets as well. References can
be convenient for this special case, but should be used with caution.

.. include:: /CodeSnippets/TypoScriptSyntax/OperatorReference.rst.txt


.. index::
   TypoScript; Operator ":="
   TypoScript; Value modifications
.. _typoscript-syntax-syntax-colon-equal-operator:
.. _typoscript-syntax-syntax-value-modification:

Value modifications with ":="
-----------------------------

This operator assigns a value to an identifier path by calling a
predefined function which modifies the existing value in different ways.
This is very useful when a value should be modified without completely
redefining it again.

A modifier is referenced by its modifier name, plus arguments in
parenthesis. These predefined functions are available:

* prependString()
    Add a string to the beginning of the existing value.

    .. code-block:: typoscript

        foo = cd
        foo := prependString(ab)
        # foo is "abcd"

* appendString()
    Add a string to the end of the existing value.

    .. code-block:: typoscript

        foo = ab
        foo := appendString(cd)
        # foo is "abcd"

* removeString()
    Remove a string from the existing value.

    .. code-block:: typoscript

        foo = foobarfoo
        foo := removeString(foo)
        # foo is "bar"

* replaceString()
    Replace old with new value. Separate these using :code:`|`.

    .. code-block:: typoscript

        foo = abcd
        foo := replaceString(bc|123)
        # foo is "a123d"

* addToList()
    Add values to the end of a list of existing values. There is no check for
    duplicate values, and the list is not sorted in any way.

    .. code-block:: typoscript

        foo = 123,456
        foo := addToList(789)
        # foo is "123,456,789"

        foo =
        foo := addToList(123)
        # foo is "123" (no leading comma added on empty existing value)

* removeFromList()
    Remove a comma-separated list of values from an existing comma-separated
    list of values. Empty values are removed as well.

    .. code-block:: typoscript

        foo = foo,123,bar,456,foo,,789
        foo:= removeFromList(foo,bar)
        # foo is "123,456,789"

* uniqueList()
    Remove duplicate entries from a comma-separated list of values.

    .. code-block:: typoscript

        foo = 123,456,abc,456,456
        foo := uniqueList()
        # foo is "123,456,abc"

* reverseList()
    Reverses the order of entries in a comma-separated list of values.

    .. code-block:: typoscript

        foo = 123,456,abc,456
        foo := reverseList()
        # foo is "456,abc,456,123"

* sortList()
    Sorts the entries in a comma-separated list of values. There are optional
    sorting parameters, multiple can be separated using :typoscript:`,`:

    ascending (default)
        Sort the items in ascending order: First numbers from small to big, then
        letters in alphabetical order.

    descending
        Sort the items in descending order: First letters in descending order, then
        numbers from big to small.

    numeric
        Apply numeric sorting: Numbers from small to big, letters sorted after "0".

    .. code-block:: typoscript

        foo = 10,100,0,20,abc
        foo := sortList()
        # foo is "0,10,20,100,abc"

        foo = 10,0,100,-20
        foo := sortList(numeric)
        # foo is "-20,0,10,100"

        foo = 10,100,0,20,-20
        foo := sortList(numeric,descending)
        # foo is "100,20,10,0,-20"

* getEnv()
    Access a $_ENV value. Resolves to empty value if not set.

    .. code-block:: typoscript

        # $_ENV['foo'] = 'fooValue'
        foo := getEnv(foo);
        # foo is "fooValue"

* "myCustomFunction()"
    ..  versionchanged:: 12.0

    The PSR-14 event :php:`\TYPO3\CMS\Core\TypoScript\AST\Event\EvaluateModifierFunctionEvent`
    is available to define custom TypoScript functions. The event replaces the hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tsparser.php']['preParseFunc']`.

    The section :ref:`EvaluateModifierFunctionEvent <EvaluateModifierFunctionEvent>`
    provides an example and the API.
