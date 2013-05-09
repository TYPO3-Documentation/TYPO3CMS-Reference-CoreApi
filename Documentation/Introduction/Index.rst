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

This document defines coding guidelines for the TYPO3 CMS project.
Following these guidelines is mandatory for TYPO3 core developers and
contributors to the TYPO3 core.

Extension authors are strongly encouraged to follow these guidelines
when developing extensions for TYPO3. Following these guidelines makes
it easier to read the code, analyze it for learning or performing code
reviews. These guidelines also help preventing typical errors in the
TYPO3 code.

This document defines how TYPO3 code, files and directories should be
structured and formatted. It does not teach how to program for TYPO3
and does not provide technical information about TYPO3.


.. _what-s-new:

What's new
^^^^^^^^^^

The latest version of the CGLs mostly contains more complete and
precise information about already existing guidelines. It also reflects
changes in the coding of TYPO3 CMS 6.0: Filenames of PHP files are no
longer required to be all lowercase. :code:`@package` and
:code:`@subpackage` annotations have been removed. Inline comments are
now no longer indented with one additional tab compared to the line
which they belong to. The coding style of long conditions has been
changed to improve readability. Finally it is made more clear that also
configuration files should follow the CGL.

Furthermore the appendix which described how to properly set up
various IDEs for working with the TYPO3 CMS Core has been moved to the
wiki: http://wiki.typo3.org/PHP\_Editors\_/\_IDE\_for\_TYPO3


.. _credits:

Credits
^^^^^^^

The original TYPO3 coding guidelines document was written by Kasper
Skårhøj. The current version is based on a complete rewrite prepared
by Ingo Renner and Dmitry Dulepov in 2008. It is currently maintained
by François Suter. All changes go through an approval process by the
TYPO3 Core Team.


.. _feedback:

Feedback
^^^^^^^^

For general questions about the documentation get in touch by writing
to `documentation@typo3.org <mailto:documentation@typo3.org>`_ .

If you find a bug in this manual, please file an issue in this
manual's bug tracker:
http://forge.typo3.org/projects/typo3v4-doc\_core\_cgl/issues

Maintaining quality documentation is hard work and the Documentation
Team is always looking for volunteers. If you feel like helping please
join the documentation mailing list (typo3.projects.documentation on
lists.typo3.org).


.. _conventions-in-this-document:

Conventions used in this document
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:code:`Monospace font` is used for:

- File names and directories. Directories have slash (:code:`/`) in
  the end of the directory name.

- Code examples

- TYPO3 module names

- Extension keys

- TYPO3 namespaces

TYPO3 Frontend and Backend are spelled with the first letter in
uppercase because they are seen as subsystems.

