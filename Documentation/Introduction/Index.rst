.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _introduction:

Introduction
------------

.. _about:

About this document
^^^^^^^^^^^^^^^^^^^

This document describes the syntax of TypoScript. It also covers the
nature of TypoScript and what the differences are between the various
contexts in which it can be used (i.e. templates and TSconfig).

If the concept of TypoScript itself is not clear, please read the
appendix ":ref:`What is TypoScript? <what-is-typoscript>`". Otherwise
feel free to ignore it.


.. _what-s-new:

What's new
^^^^^^^^^^

This version of the manual was updated for TYPO3 CMS 6.2.

The changes include adding the new INCLUDE_TYPOSCRIPT option DIR,
which allows to include all files from a directory and from
subdirectories recursively, optionally restricted to certain file
types. Files can now be included from a file relatively to the
location of this file. Dots in object paths can now be escaped using
the backslash character.


.. _credits:

Credits
^^^^^^^

This document was formerly maintained by Michael Stucki and François
Suter. Additions have been made by Sebastian Michaelsen. The updates
for recent versions were done by Christopher Stelmaszyk.


.. _feedback:

Feedback
^^^^^^^^

For general questions about the documentation get in touch by writing
to `documentation@typo3.org <mailto:documentation@typo3.org>`_ .

If you find a bug in this manual, please be so kind as to check the
online version on http://docs.typo3.org/typo3cms/TyposcriptSyntaxReference/.
From there you can hit the "Edit me on GitHub" button in the top right corner
and submit a pull request via GitHub. Alternatively you can just file an issue
using the bug tracker: https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-TyposcriptSyntax/issues.

Maintaining high quality documentation requires time and effort
and the TYPO3 Documentation Team always appreciates support.
If you want to support us, please join the documentation
mailing list/forum (http://forum.typo3.org/index.php/f/44/).
