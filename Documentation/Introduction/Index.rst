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

This version is updated for TYPO3 CMS 6.2.

Many recent changes in the TYPO3 CMS code base were documented in
this new version of Core APIs, some dating back to version 6.1.
The release of a new LTS version was the opportunity to put extra
efforts into the manuals.

Highlights from new features brought by TYPO3 CMS 6.2:

- an :ref:`Application Context <bootstrapping-context>`, backported from TYPO3 Flow.

- changes to the caching framework, in particuler the new
  :ref:`cache groups <caching-architecture-core>`.

- well-known folder :file:`t3lib` is now gone and so is constant
  :code:`PATH_t3lib`.

- a new API for registering AJAX handlers which provides
  `CSRF <https://en.wikipedia.org/wiki/Cross-site_request_forgery>`__ protection
  (documentation yet missing, but will come very soon).

- the system categories API has matured and the :ref:`related chapter <categories>`
  was extended. In particular, it is now possible to have more than one
  categories field per table.

- usage of :ref:`flash messages in Extbase <flash-messages-extbase>`
  has changed.

- it is possible to :ref:`define a custom mirror <xliff-translating-servers>`
  to fetch extension translations from.


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

If you find a bug in this manual, please be so kind as to check the
online version on http://docs.typo3.org/typo3cms/CoreApiReference/.
From there you can hit the "Edit me on GitHub" button in the top right corner
and submit a pull request via GitHub. Alternatively you can just file an issue
using the bug tracker: https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues.

Maintaining high quality documentation requires time and effort
and the TYPO3 Documentation Team always appreciates support.
If you want to support us, please join the documentation
mailing list/forum (http://forum.typo3.org/index.php/f/44/).


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


