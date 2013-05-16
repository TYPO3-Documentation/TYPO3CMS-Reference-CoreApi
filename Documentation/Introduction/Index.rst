.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt





.. _introduction:

Introduction
============


.. _overview:

Overview
--------

TYPO3 is known for its extensibility. However to really benefit from
this power, a complete documentation is needed. "Core APIs" and its
companion, "Inside TYPO3", aim to provide such information to
developers and administrators. Not all areas are covered with the same
amount of details, but at least some pointers are provided.

"Inside TYPO3" contains the overall introduction to the architecture
of the TYPO3 core. It also contains API descriptions to a certain
degree but mostly in the form of examples and short table listings.
"Core APIs" goes into much more detail about such APIs and covers
subjects more closely related to development.

These documents do *not* contain any significant information about
the frontend of TYPO3. Creating templates, setting up TypoScript
objects etc. is not the scope of these documents; they are about the
*backend* part of the core only.

The TYPO3 Documentation Team hopes that these two documents, "Inside TYPO3" and
"TYPO3 Core APIs", will form a complete picture of the TYPO3 Core
architecture, the backend and be the reference of choice in your work
with TYPO3. It took Kasper more than a year to get the first version
published and we've tried to maintain it as best we could.


.. _what-s-new:

What's new
^^^^^^^^^^

This version is updated for TYPO3 CMS 6.1.

The handling of TCA was refactored, so that this global array is always
loaded. Thus calls to :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA()`
are not needed anymore.

There is also a new cache backend based on :ref:`Xcache <caching-backend-xcache>`.


.. _code-examples:

Code examples
-------------

Many of the code examples found in this document come from the TYPO3
Core itself.

Quite a few others come from the "examples" extension which is
available in the TER. You can install it if you want to try out these
examples yourself and use them as a basis for your own stuff.

Yet some other examples just belong to this manual. Some may be moved
to the "examples" extension at some later stage.


.. _feedback:

Feedback
^^^^^^^^

For general questions about the documentation get in touch by writing
to `documentation@typo3.org <mailto:documentation@typo3.org>`_ .

If you find a bug in this manual, please file an issue in this
manual's bug tracker:
`http://forge.typo3.org/projects/typo3v4-doc_core_api/issues
<http://forge.typo3.org/projects/typo3v4-doc_core_api/issues>`_

Maintaining quality documentation is hard work and the Documentation
Team is always looking for volunteers. If you feel like helping please
join the documentation mailing list (typo3.projects.documentation on
lists.typo3.org).


.. _credits:

Credits
-------

This manual was originally written by Kasper Skårhøj. It was further
maintained, refreshed and expanded by François Suter.


.. _dedication:

Dedication
----------

I want to dedicate this document to the people in the TYPO3 community
who have the  *discipline* to do the boring job of writing
documentation for their extensions or contribute to the TYPO3
documentation in general. It's great to have good coders, but it's
even more important to have coders with character to carry their work
through till the end - even when it means spending days writing good
documents. Go for completeness!

\- kasper


