.. include:: ../Includes.txt

.. _introduction:

Introduction
============


.. _about:

About this document
-------------------

TYPO3 is known for its extensibility. To really benefit from
this power, a complete documentation is needed: "Core APIs" aims to
provide such information to developers and administrators. Not all areas
are covered with the same amount of detail, but at least some pointers are provided.

The document does *not* contain any significant information about
the frontend of TYPO3. Creating templates, setting up TypoScript
objects etc. is not the scope of the document, it addresses the
*backend* part of the core only.

The TYPO3 Documentation Team hopes that this document will form a complete picture
of the TYPO3 Core architecture and the backend. It will hopefully be the reference
of choice in your work with TYPO3.


.. _audience:

Intended audience
~~~~~~~~~~~~~~~~~

This document is intended to be a reference for experienced TYPO3 CMS
developers. For intermediates it will help you to become experienced!
But the document presumes that you are well familiar with TYPO3 and
the concepts herein. Further it will presume knowledge in the
technical end: PHP, MySQL, Unix etc.

The goal is to take you "under the hood" of TYPO3 CMS. To make the
principles and opportunities clear and less mysterious. To educate you
to help continue the development of TYPO3 along the already
established lines so we will have a consistent CMS application in a
future as well. And hopefully my teaching on the deep technical level
will enable you to educate others higher up in the "hierarchy". Please
consider that as well!


.. _code-examples:

Code examples
~~~~~~~~~~~~~

Many of the code examples found in this document come from the TYPO3
Core itself.

Quite a few others come from the "examples" and the "styleguide" extension. You can
install them if you want to try out these examples yourself and use them as
a basis for your own stuff.

Yet some other examples just belong to this manual. Some may be moved
to the "examples" extension at some later stage.


.. _feedback:

Feedback and Fixing
~~~~~~~~~~~~~~~~~~~

If you find a bug in this manual, please be so kind as to check the
`online version on <https://docs.typo3.org/typo3cms/CoreApiReference/>`__.
From there you can hit the "Edit me on GitHub" button in the top right corner
and submit a pull request via GitHub. Alternatively you can just `file an issue
using the bug tracker <https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues>`__.

Maintaining high quality documentation requires time and effort
and the TYPO3 Documentation Team always appreciates support.

If you want to support us, please join the slack channel **#typo3-documentation**
on `Slack <https://typo3.slack.com/>`__.
Visit `forger <https://forger.typo3.org/slack>`__ to gain access to Slack.

And finally, as a last resort, you can get in touch with the documentation team
`by mail <documentation@typo3.org>`_.


.. _credits:

Credits
~~~~~~~

This manual was originally written by Kasper Skårhøj. It was further
maintained, refreshed and expanded by François Suter.


.. _dedication:

Dedication
~~~~~~~~~~

I want to dedicate this document to the people in the TYPO3 community
who have the  *discipline* to do the boring job of writing
documentation for their extensions or contribute to the TYPO3
documentation in general. It's great to have good coders, but it's
even more important to have coders with character to carry their work
through till the end - even when it means spending days writing good
documents. Go for completeness!

\- kasper


.. _overview:

Overview
--------

For most people TYPO3 is equivalent to a CMS providing a backend for
management of the content and a frontend engine for website display.
However TYPO3s core is natively designed to be a general purpose
framework for management of database content. The core of TYPO3 CMS
delivers a set of principles for storage of this content, user access
management, editing of the content, uploading and managing files etc.
Many of these principles are expressed as an API (Application
Programming Interface) for use in *extensions* which ultimately
add most of the real functionality.

.. figure:: ../Images/Typo3CmsStructure.png
   :alt: Main TYPO3 CMS core architecture


So the *core* is the skeleton and  *extensions* are the muscles,
fibers and skin making a full bodied CMS. In this document I cut to
the bone and provide a detailed look at the core of TYPO3 CMS including
the API available to the outside. This is supposed to be the final
technical reference apart from source code itself which
is - of course - the ultimate documentation.
