.. include:: /Includes.rst.txt
.. index::
   TypoScript; Operator "["
   TypoScript; Conditions
   TypoScript; [GLOBAL] condition
   TypoScript; Symfony expression language
.. _typoscript-syntax-conditions:
.. _typoscript-syntax-syntax-square-brackets:
.. _typoscript-syntax-syntax-conditions:
.. _typoscript-syntax-syntax-value:
.. _typoscript-syntax-else-condition:
.. _typoscript-syntax-end-condition:
.. _typoscript-syntax-global-condition:
.. _typoscript-syntax-conditions-expression-language:
.. _typoscript-syntax-implementing-custom-conditions:


==========
Conditions
==========

TypoScript can contain :code:`if` and :code:`if / else` control structures. They
are called `conditions`, their "body" is only considered if a condition criteria
evaluates to true. Examples of condition criteria are:

-  Is a user logged in?

-  Is it Monday?

-  Is the page called in a certain language?

Conditions are a TypoScript syntax construct. They are thus available in both
frontend TypoScript and backend TSconfig. However, condition criteria are based
on prepared variables and functions, and those are different in frontend
TypoScript and backend TSconfig. For example, the :typoscript:`frontend` variable does
not exist in TSconfig, it is (obviously) impossible to have a backend TSconfig
condition that checks for a logged in frontend user.

For a reference of allowed condition criteria, please refer to the according
chapter in the :ref:`frontend TypoScript Reference <t3tsref:conditions>` and
the :ref:`backend TSconfig Reference <t3tsconfig:conditions>`. These references
come with examples for single condition criteria as well.

The TSconfig and TypoScript backend modules show lists of existing conditions
and allow simulating criteria verdicts to analyze their impact on the
resulting TypoScript tree.

Condition criteria are based on
the `Symfony expression language <https://symfony.com/doc/current/components/expression_language/syntax.html>`__.
The Core allows extending the Symfony expression language with own variables and
functions, see :ref:`symfony expression language API <sel-within-typoscript-conditions>`
for more details.


Basic example
=============

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions1.rst.txt


.. _typoscript-syntax-conditions-syntax:

Syntax and rules
================

The general syntax is like this:

.. include:: /CodeSnippets/TypoScriptSyntax/Conditions2.rst.txt

These general rules apply:

* Conditions are encapsulated in :typoscript:`[` and :typoscript:`]`

* :typoscript:`[ELSE]` negates a previous condition criteria and can contain
  a new body until :typoscript:`[END]` or :typoscript:`[GLOBAL]`. :typoscript:`[ELSE]`
  is considered if the condition criteria did *not* evaluate to true.

* :typoscript:`[END]` and :typoscript:`[GLOBAL]` stop a given condition scope.
  This is similar to a closing curly brace :code:`}` in programming languages like PHP.

  .. versionchanged:: 12.0

  :typoscript:`[END]` and :typoscript:`[GLOBAL]` behave exactly the same. Both
  are kept for historical reasons (for now).

* Conditions can use constants. They are available in frontend TypoScript "setup" and
  in TSconfig from "site settings". A simple example if this constant
  :typoscript:`myPageUid = 42` is set:

  .. code-block:: typoscript

      [traverse(page, "uid") == {$myPageUid}]
          page.10.value = Page uid is 42
      [end]

* Multiple condition criteria can be combined using :typoscript:`or` or :typoscript:`||`,
  as well as :typoscript:`and` or :typoscript:`&&`

* Single criteria can be negated using :typoscript:`!`

* Conditions can *not* be nested within code blocks.

  .. versionchanged:: 12.0

  Conditions *can* be nested into each other, if they are located in
  different snippets (files or records), see example below. They can *not* be nested
  within the same code snippet.

* A second condition that is *not* :typoscript:`[ELSE]`, :typoscript:`[END]`
  or :typoscript:`[GLOBAL]` *stops* a previous condition and starts a new one.
  This is the main reason conditions can *not* be nested within one text snippet.

* .. versionchanged:: 12.0

  :typoscript:`@import` and :typoscript:`<INCLUDE_TYPOSCRIPT: ...` *can* be nested
  inside conditions. This allows conditional includes and is a new feature of the
  TYPO3 v12 parser.

* .. versionchanged:: 12.0

  Conditions automatically stop at the end of a text snippet (file or record), even
  without :typoscript:`[END]` or :typoscript:`[GLOBAL]`. Another snippet on the same
  level is in "global" scope automatically. The backend TypoScript and
  TSconfig modules may mumble about a not properly closed condition, though.


.. _typoscript-syntax-conditions-usage:
.. _typoscript-syntax-conditions-combine:
.. _typoscript-syntax-conditions-confinements:
.. _typoscript-syntax-conditions-braces:
.. _typoscript-syntax-the-global-condition:
.. _typoscript-syntax-conditions-examples:

Examples
========

* If a user is logged in, or if the client is local, text will be
  output in upper case:

  .. include:: /CodeSnippets/TypoScriptSyntax/Conditions3.rst.txt

* In case :code:`if` is empty and only a :code:`else` body is needed for a
  single condition criteria, these two are identical:

  .. include:: /CodeSnippets/TypoScriptSyntax/Conditions4.rst.txt

* Conditions can *not* be nested within curly braces. The example below
  is invalid syntax and the backend modules mumble with "missing braces":

  .. include:: /CodeSnippets/TypoScriptSyntax/Conditions5.rst.txt
