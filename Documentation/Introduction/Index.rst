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

If you find a bug in this manual, please file an issue in this
manual's bug tracker:
`https://forge.typo3.org/projects/typo3cms-doc-typoscript-syntax/issues
<https://forge.typo3.org/projects/typo3cms-doc-typoscript-syntax/issues>`_

Maintaining quality documentation is hard work and the Documentation
Team is always looking for volunteers. If you feel like helping please
join the documentation mailing list (typo3.projects.documentation on
lists.typo3.org).

