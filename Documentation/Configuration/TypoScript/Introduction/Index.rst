.. include:: /Includes.rst.txt
.. index:: ! TypoScript
.. _typoscript-syntax-introduction:
.. _typoscript-syntax-what-is-typoscript:
.. _typoscript-syntax-credits:

============
Introduction
============

What is TypoScript?
===================

People are sometimes confused about what TypoScript is, where it can
be used, and have a tendency to think of it as something complex. This
chapter has been written to clarify these assumptions a bit.

Let's start with a basic truth: TypoScript is an efficient syntax for defining
information in a hierarchical structure based on plain text.

This means TypoScript does not "do" anything - it just structures information.
It's more similar to a `markup language <https://en.wikipedia.org/wiki/Markup_language>`__
like HTML than to a full fledged programming language. Interpreting TypoScript
is done in a certain context where single keywords get "meaning" by triggering some
processing. For instance, the frontend rendering chain "understands"
:typoscript:`page = PAGE` and sets up certain frontend output related scaffolding
due to this.

In more academic terms, TypoScript is *not* `Turing-complete <https://en.wikipedia.org/wiki/Turing_completeness>`__:
While there is a concept of "if" (see "conditions"), it is not possible
to define dynamic variables ("constants" in TypoScript can't change their value
at runtime), and it's also not possible to have programming loops
as such. Interpreting TypoScript is done by PHP which may trigger programming
loops based on TypoScript configuration, but the syntax does not contain such
a construct itself.

TypoScript does not contain data, but configuration: Data is typically stored
in the database, edited by backend editors, and (frontend) TypoScript is only used
to configure which specific data is retrieved from the database and how it should be
processed to prepare output. In the backend, TypoScript (which we call `TSconfig`
in this scope) is used to toggle PHP backend controller functionality,
for instance, to enable or disable UI elements, to change defaults, and
similar.


.. index:: TypoScript; PHP arrays
.. _typoscript-syntax-php-arrays:
.. _typoscript-syntax-object-paths:
.. _typoscript-syntax-semantics:
.. _typoscript-syntax-parsed-php-array:

TypoScript parsing
==================

Both the frontend and the backend deal with TypoScript syntax. The parser,
which translates TypoScript text snippets into some structure (an object tree
or a PHP array), that can be interpreted by the frontend or the backend, is
thus a core concept and located in the core extension. Integrators and
developers don't have to directly deal with the parser in most cases, the system
provides higher level API doing all the dirty groundwork.

Developers and integrators with knowledge of PHP can think of the parsed
TypoScript as a multidimensional PHP array. In comparison to arrays in PHP,
TypoScript syntax allows a more relaxed handling of syntax errors, definition of
values with less needed language symbols and an efficient way to copy and
unset bigger sub arrays.
