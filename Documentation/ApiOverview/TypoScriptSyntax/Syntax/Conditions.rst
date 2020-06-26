.. include:: ../../../Includes.txt


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

- Is a usergroup set for the current session?

- Is it Monday?

- Is the GET parameter "&language=uk" set?

- Is it my mother's birthday?

- Do I feel lucky today?

Of these examples admittedly the first few are the most realistic. In
fact they are readily available in the context of TypoScript
Templates. But a condition can theoretically evaluate any circumstance
and return either TRUE or FALSE which subsequently means the parsing
of the TypoScript code that follows.

.. seealso::

   For conditions usage examples, and available variables and function reference, please refer to
   :ref:`the TypoScript Reference conditions chapter <t3tsref:conditions>`.

.. _typoscript-syntax-conditions-usage:

Where Conditions Can Be Used
============================

The *detection of conditions* is a part of the TypoScript syntax but
the *validation* of the condition content always relies on the
context where TypoScript is used. Therefore in plain syntax
highlighting (no context) conditions are just highlighted and nothing
more. In the context of TypoScript Templates there is a
:ref:`whole section of TSref <t3tsref:conditions>` which defines the
syntax of the condition contents for TypoScript Templates. For "Page
TSconfig" and "User TSconfig" conditions are implemented as well.
Basically they work the same way as conditions in TypoScript
templates do, but there are some small differences. For details see the
:ref:`chapter on conditions in TSconfig <t3tsconfig:conditions>`.


.. _typoscript-syntax-conditions-syntax:

The Syntax of Conditions
========================

A condition is written on its own line and is detected by :code:`[`
(square bracket) being the first character on that line:

.. code-block:: typoscript

   (Some TypoScript)

   [ condition ]

   (Some TypoScript only parsed if the condition is met.)

   [GLOBAL]

   (Some TypoScript)

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

.. code-block:: typoscript

   page = PAGE
   page.10 = TEXT
   page.10.value = HELLO WORLD!

   [loginUser('*') or ip('127.0.0.1')]
      page.20 = TEXT
      page.20 {
         value = Only for logged in users or local setup
         stdWrap.case = upper
      }
   [GLOBAL]

You can now use the Object Browser to actually see the difference in
the parsed object tree depending on whether the condition evaluates to
TRUE or FALSE (which can be simulated with that module as you can
see):

.. figure:: ../Images/ConditionsSyntax.png
   :alt: The Object Browser showing different objects depending on whether
         a condition is set or unset.


.. _typoscript-syntax-conditions-combine:

Combining Conditions
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

.. note::

   Before TYPO3 10, it was possible to "chain" multiple condition blocks
   together with :code:`AND`, :code:`OR`, :code:`&&` and :code:`||` by writing
   something like :code:`[ condition 1 ][ condition 2 ]` or
   :code:`[ condition 1 ] AND [ condition 2 ]`. This is no longer possible or
   necessary, as with the new :ref:`symfony-expression-language`,
   only single condition blocks on one line are now allowed. Logical operators
   like :code:`and`, :code:`or`  or :code:`not` are now used *inside* the
   condition block to allow for writing complex expressions.


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

.. code-block:: typoscript

   page = PAGE
   page.10 = TEXT

   [loginUser('*')]
      page.10.value = Logged in
   [ELSE]
      page.10.value = Not logged in
   [END]

   page.10.stdWrap.wrap = <strong>|</strong>

Here we have one output text if a user is logged in and
another if not. No matter what the text is wrapped in a :code:`<strong>` tag,
because, as we can see, this wrap is added outside of the condition block
(e.g. after the :code:`[END]` condition).

.. figure:: ../Images/ConditionsSyntaxElse.png
   :alt: The TypoScript object browser showing the output of an ELSE condition.

The fact that you can "enable" the condition in the TypoScript Object
Browser is a facility provided to simulate the outcome of any
conditions you insert in a TypoScript Template. Whether or not the
conditions validate correctly is only verified by actually getting
(in this example) a logged in user and hitting the site.

Another example could be if you wanted to do something special in case
a bunch of conditions is NOT true. There's **no negate-character**,
but you could do this:

.. code-block:: typoscript

   [!loginUser('*')]
     page.10.value = No user is logged in!
   [END]


.. _typoscript-syntax-conditions-confinements:
.. _typoscript-syntax-conditions-braces:

Where to insert conditions in TypoScript?
=========================================

Conditions can be used *outside* of confinements (curly braces) only!

So, this is valid:

.. code-block:: typoscript

   someObject {
      1property = 234
   }
   [loginUser('*')]
   someObject {
      2property = 567
   }

But this is **not valid:**

.. code-block:: typoscript

   someObject {
      1property = 234
      [loginUser('*')]
      2property = 567
   }

When parsed with syntax highlighting you will see this error:

.. figure:: ../Images/ConditionsSyntaxError.png
   :alt: Error after having used a condition where it is not allowed.

This means that the line was perceived as a regular definition of
TypoScript and not as a condition.


.. _typoscript-syntax-the-global-condition:

The [GLOBAL] Condition
======================

The :code:`[GLOBAL]` special condition (which resets any previous
condition scope) is yet different, in that will be detected at
*any line* except within multiline value definitions.

.. code-block:: typoscript

   someObject {
      1property = 234
      [GLOBAL]
      2property = 567
   }

But you will still get some errors if you syntax highlight it:

.. figure:: ../Images/ConditionsSyntaxErrorGlobal.png
   :alt: Error after having used a GLOBAL condition at thw wrong place.

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


.. _typoscript-syntax-conditions-expression-language:

Custom Conditions With Symfony Expression Language
==================================================

It is possible to provide own functions with extensions.
Use as reference the class :php:`TYPO3\CMS\Core\ExpressionLanguage\TypoScriptConditionFunctionsProvider` which implements
the most core functions.

Add new methods by implementing own providers which implement the :php:`ExpressionFunctionProviderInterface` and
register the provider in :file:`ext_localconf.php`:

.. code-block:: php

   if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Core\ExpressionLanguage\TypoScriptConditionProvider']['additionalExpressionLanguageProvider'])) {
      $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Core\ExpressionLanguage\TypoScriptConditionProvider']['additionalExpressionLanguageProvider'] = [];
   }
   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Core\ExpressionLanguage\TypoScriptConditionProvider']['additionalExpressionLanguageProvider'][] = \My\NameSpace\Provider\TypoScriptConditionProvider::class;


.. _typoscript-syntax-conditions-summary:

Summary
=======

- Conditions are detected by :code:`[` as the first line character (whitespace
  ignored).

- Conditions are evaluated in relation to the context where TypoScript
  is used. They are widely used in TypoScript Templates and can also be
  used in Page TSconfig or User TSconfig.

- Special conditions :code:`[ELSE]`, :code:`[END]` and :code:`[GLOBAL]` exist.

- Conditions can be used outside of confinements (curly braces) only.
  However the :code:`[GLOBAL]` condition will always break a confinement if
  entered inside of one.

