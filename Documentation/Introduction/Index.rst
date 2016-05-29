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
precise information about already existing guidelines. It reflects
the coding of TYPO3 CMS 8.

Furthermore the appendix which described how to properly set up
various IDEs for working with the TYPO3 CMS Core has been moved to the
wiki: https://wiki.typo3.org/PHP\_Editors\_/\_IDE\_for\_TYPO3


.. _credits:

Credits
^^^^^^^

The original TYPO3 coding guidelines document was written by Kasper
Skårhøj. The current version is based on a complete rewrite prepared
by Ingo Renner and Dmitry Dulepov in 2008. It is currently maintained
by François Suter. All changes go through an approval process by the
TYPO3 Active Contributors Team.


.. _feedback:

Feedback
^^^^^^^^

For general questions about the documentation get in touch by writing
to `documentation@typo3.org <mailto:documentation@typo3.org>`_ .

If you find a bug in this manual, please be so kind as to check the
online version on https://docs.typo3.org/typo3cms/CodingGuidelinesReference/.
From there you can hit the "Edit me on GitHub" button in the top right corner
and submit a pull request via GitHub. Alternatively you can just file an issue
using the bug tracker: https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CodingGuidelines/issues.

Maintaining high quality documentation requires time and effort
and the TYPO3 Documentation Team always appreciates support.
If you want to support us, please join the documentation
mailing list/forum (http://forum.typo3.org/index.php/f/44/).


.. _quality-assurance:

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


.. _conventions-in-this-document:

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

