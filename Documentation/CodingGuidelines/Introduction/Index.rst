.. include:: ../Includes.txt


.. _cgl-introduction:

Introduction
------------


.. _cgl-about:

About this chapter
^^^^^^^^^^^^^^^^^^^

This chapter defines coding guidelines for the TYPO3 CMS project.
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


.. _cgl-what-s-new:

What's new
^^^^^^^^^^

The latest version of the CGLs mostly contains more complete and
precise information about already existing guidelines. It reflects
the coding of TYPO3 CMS 8.



.. _cgl-credits:

Credits
^^^^^^^

The original TYPO3 coding guidelines document was written by Kasper
Skårhøj. The current version is based on a complete rewrite prepared
by Ingo Renner and Dmitry Dulepov in 2008.

All changes go through an approval process by the
TYPO3 Core Team.


.. _cgl-quality-assurance:

The CGL as a means of quality assurance
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Our programmers know the CGL and are encouraged to inform authors,
should their code not comply with the guidelines.

Apart from that, adhering to the CGL is not voluntary; the CGL are also
enforced by structural means: Automated tests are run by the continuous
integration tool Jenkins to make sure that every code change complies
with the CGL. In case a change does not meet the criteria, Jenkins will
give a negative vote in the review system and point to the according
problem.


.. _cgl-conventions-in-this-document:

Conventions used in this document
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:code:`Monospace font` is used for:

- File names and directories. Directories have a slash (:code:`/`) at
  the end of the directory name.

- Code examples

- TYPO3 module names

- Extension keys

- TYPO3 namespaces

TYPO3 Frontend and Backend are spelled with the first letter in
uppercase because they are seen as subsystems.

