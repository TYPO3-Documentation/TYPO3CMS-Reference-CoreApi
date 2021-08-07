.. include:: /Includes.rst.txt
.. index:: ! TypoScript; Conditions
.. _typoscript-syntax-conditions:

==========
Conditions
==========

There is a *possibility* of using so called *conditions* in
TypoScript. Conditions are simple control structures, that evaluate to
TRUE or FALSE based on some criteria (externally validated) and
thereby determine, whether the TypoScript code following the condition
and ending where the next condition is found, should be parsed or not.

Examples of a condition could be:

-  Is a usergroup set for the current session?

-  Is it Monday?

-  Is the GET parameter "&language=uk" set?

-  Is it my mother's birthday?

-  Do I feel lucky today?

Of these examples admittedly the first few are the most realistic. In
fact they are readily available in the context of TypoScript
Templates. But a condition can theoretically evaluate any circumstance
and return either TRUE or FALSE which subsequently means the parsing
of the TypoScript code that follows.

.. seealso::

   For conditions usage examples, and available variables and function reference, please refer to
   :ref:`the TypoScript Reference conditions chapter <t3tsref:conditions>`.


.. _typoscript-syntax-conditions-usage:

Where conditions can be used
============================

The *detection of conditions* is a part of the TypoScript syntax but
the *validation* of the condition content always relies on the
context where TypoScript is used. Therefore in plain syntax
highlighting (no context) conditions are just highlighted and nothing
more. In the context of TypoScript Templates there is a
:ref:`whole section of TSref <t3tsref:conditions>` which defines the
syntax of the condition contents for TypoScript Templates. For "Page
TSconfig" and "user TSconfig" conditions are implemented as well.
Basically they work the same way as conditions in TypoScript
templates do, but there are some small differences. For details see the
:ref:`chapter on conditions in TSconfig <t3tsconfig:conditions>`.


.. _typoscript-syntax-conditions-syntax:

The syntax of conditions
========================

A condition is written on its own line and is detected by :code:`[`
(square bracket) being the first character on that line:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Syntax.rst.txt

As you can see from this example, the line :code:`[GLOBAL]` also is a
condition. It is built into TypoScript and always returns TRUE. The
line :code:`[ condition ]` is another condition.
If :code:`[ condition ]` is TRUE, then the TypoScript in the
middle would be parsed until :code:`[GLOBAL]` (or :code:`[END]`) resets the
condition. After that point the TypoScript is parsed for any case
again.


Here is an example of some TypoScript (from the context of TypoScript
Templates) where another text is output if you are logged in or
working locally:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Simple.rst.txt

You can now use the Object Browser to actually see the difference in
the parsed object tree depending on whether the condition evaluates to
TRUE or FALSE (which can be simulated with that module as you can
see):

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/ConditionsSyntaxDisabled.rst.txt

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/ConditionsSyntaxEnabled.rst.txt


.. _typoscript-syntax-conditions-combine:

Combining conditions
====================

As we saw above two or more tests can be combined using logical operators.
The following operators are available:

or
  Also available as :code:`||`.

and
  Also available as :code:`&&`.

not
  Also available as :code:`!`.

TypoScript conditions are using the Symfony Expression Language. For more
information on writing such expressions, you can look up the
`symfony documentation on the expression language <https://symfony.com/doc/current/components/expression_language/syntax.html>`__.

.. _typoscript-syntax-else-condition:
.. _typoscript-syntax-end-condition:
.. _typoscript-syntax-global-condition:

The Special [ELSE], [END] and [GLOBAL] Conditions
=================================================

The special condition :code:`[ELSE]` which will return TRUE if
the previous condition returned FALSE. To end an :code:`[ELSE]` condition you
can use either :code:`[END]` or :code:`[GLOBAL]`. For all three conditions you can
also use them in lower case.

Here's an example of using the :code:`[ELSE]` condition (also in the context
of TypoScript Templates):

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Else.rst.txt

Here we have one output text if a user is logged in and
another if not. No matter what the text is wrapped in a :code:`<strong>` tag,
because, as we can see, this wrap is added outside of the condition block
(e.g. after the :code:`[END]` condition).

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/ConditionsElseDisabled.rst.txt

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/ConditionsElseEnabled.rst.txt

The fact that you can "enable" the condition in the TypoScript Object
Browser is a facility provided to simulate the outcome of any
conditions you insert in a TypoScript Template. Whether or not the
conditions validate correctly is only verified by actually getting
(in this example) a logged in user and hitting the site.

Another example could be if you wanted to do something special in case
a bunch of conditions is NOT true. There's **no negate-character**,
but you could do this:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Not.rst.txt


.. _typoscript-syntax-conditions-confinements:
.. _typoscript-syntax-conditions-braces:

Where to insert conditions in TypoScript?
=========================================

Conditions can be used *outside* of confinements (curly braces) only!

So, this is valid:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Valid.rst.txt

But this is **not valid:**

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Invalid.rst.txt

When parsed with syntax highlighting you will see this error:

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/ConditionsSyntaxError.rst.txt

This means that the line was perceived as a regular definition of
TypoScript and not as a condition.


.. index:: TypoScript; [GLOBAL] condition
.. _typoscript-syntax-the-global-condition:

The [GLOBAL] condition
======================

The :code:`[GLOBAL]` special condition (which resets any previous
condition scope) is yet different, in that will be detected at
*any line* except within multiline value definitions.

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/InvalidGlobal.rst.txt

But you will still get some errors if you syntax highlight it:

.. include:: /Images/AutomaticScreenshots/TypoScriptSyntax/ConditionsSyntaxErrorGlobal.rst.txt

The reason for this is that the :code:`[GLOBAL]` condition aborts the
confinement started in the first line resulting in the first error
("... short of 1 end brace(s)"). The second error appears because the
end brace is now in excess since the "brace level" was reset by
:code:`[GLOBAL]`.

So, in summary; the special :code:`[global]` (or :code:`[GLOBAL]`) condition will
break TypoScript parsing within braces at any time and return to the
global scope (unless entered in a multiline value). This is true for
any TypoScript implementation whether other condition types are
possible or not. Therefore you can use :code:`[GLOBAL]` (put on a single line
for itself) to make sure that following TypoScript is correctly parsed
from the top level. This is normally done when TypoScript code from
various records is combined.


.. index:: TypoScript; Symfony expression language
.. _typoscript-syntax-conditions-expression-language:

Custom conditions with the Symfony expression language
======================================================

Further information about how to extend TypoScript with your own custom
conditions can be found at :ref:`sel-within-typoscript-conditions`.


.. _typoscript-syntax-conditions-examples:

Syntax examples
===============

Variables and functions
-----------------------

For a detailed list of the available objects and functions refer to the
:ref:`TypoScript Reference <t3tsref:conditions>`.

Variables:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Variables.rst.txt

Functions:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Functions.rst.txt


Literals
--------

For a complete list have a look at the
`SEL supported literals <https://symfony.com/doc/current/components/expression_language/syntax.html#supported-literals>`__.

Strings:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Strings.rst.txt

Arrays:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Arrays.rst.txt


Operators
---------

Please see a complete list of available operators here:
`SEL syntax operators <https://symfony.com/doc/current/components/expression_language/syntax.html#comparison-operators>`__

Equality:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Equality.rst.txt

Wildcards:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/Wildcards.rst.txt

.. note::

   While the other operator are inherent features of the Symphony expression
   language :typoscript:`like` is a function defined by TYPO3. Read more about
   it in :ref:`TypoScript Reference, Conditions,
   function like <tsref:condition-function-like>`

Regular expressions:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/RegularExpressions.rst.txt

Array operators:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/ArrayOperators.rst.txt

Combined conditions
-------------------

And conditions:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/AndConditions.rst.txt

Or conditions:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions/OrConditions.rst.txt

.. _typoscript-syntax-conditions-summary:

Summary
=======

-  Conditions are detected by :code:`[` as the first line character (whitespace
   ignored).

-  Conditions are evaluated in relation to the context where TypoScript
   is used. They are widely used in TypoScript Templates and can also be
   used in page TSconfig or user TSconfig.

-  Special conditions :code:`[ELSE]`, :code:`[END]` and :code:`[GLOBAL]` exist.

-  Conditions can be used outside of confinements (curly braces) only.
   However the :code:`[GLOBAL]` condition will always break a confinement if
   entered inside of one.
