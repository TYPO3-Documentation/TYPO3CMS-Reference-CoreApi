.. include:: ../Includes.txt

.. _introduction:

Introduction
============


.. _about:

About this document
-------------------

TYPO3 is known for its extensibility. To really benefit from
this power, a complete documentation is needed: "TYPO3 Explained" aims to
provide such information to everyone. Not all areas are covered with the
same amount of detail, but at least some pointers are provided.

The document does *not* contain any significant information about
the frontend of TYPO3. Creating templates, setting up TypoScript
objects etc. is not the scope of the document, it addresses the
*backend* and management part of the core only.

The TYPO3 Documentation Team hopes that this document will form a complete picture
of the TYPO3 Core architecture. It will hopefully be the knowledge base
of choice in your work with TYPO3.


.. _audience:

Intended audience
~~~~~~~~~~~~~~~~~

This document is intended to be a reference for TYPO3 CMS developers and partially
for integrators. The document explains all major parts of TYPO3 and the concepts.
Some chapters presumes knowledge in the technical end: PHP, MySQL, Unix etc, depending
on the specific chapter.

The goal is to take you "under the hood" of TYPO3 CMS. To make the
principles and opportunities clear and less mysterious. To educate you
to help continue the development of TYPO3 along the already
established lines so we will have a consistent CMS application in a
future as well. And hopefully this teaching on the deep technical level
will enable you to educate others higher up in the "hierarchy". Please
consider that as well!


.. _code-examples:

Code examples
~~~~~~~~~~~~~

Many of the code examples found in this document come from the TYPO3
Core itself.

Quite a few others come from the "`styleguide <https://github.com/TYPO3/styleguide>`__"
extension. You can install it, if you want to try out these examples yourself and
use them as a basis for your own extensions.

.. _feedback:

Feedback and Fixing
~~~~~~~~~~~~~~~~~~~

If you find a bug in this manual, please be so kind as to check the
`online version <https://docs.typo3.org/typo3cms/CoreApiReference/>`__.
From there you can hit the "Edit me on GitHub" button in the top right corner
and submit a pull request via GitHub. Alternatively you can just `file an issue
using the bug tracker <https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues>`__.

Maintaining high quality documentation requires time and effort
and the TYPO3 Documentation Team always appreciates support.

If you want to support us, please join the slack channel **#typo3-documentation**
on `Slack <https://typo3.slack.com/>`__ (`Register for Slack <https://my.typo3.org/about-mytypo3org/slack/>`__).

And finally, as a last resort, you can get in touch with the documentation team
`by mail <documentation@typo3.org>`_.


.. _credits:

Credits
~~~~~~~

This manual was originally written by Kasper Skårhøj. It was further
maintained, refreshed and expanded by François Suter.

The first version of the security chapter has been written by Ekkehard Guembel and Michael Hirdes
and we would like to thank them for this. Further thanks to the TYPO3 Security Team for
their work for the TYPO3 project. A special thank goes to Stefan Esser for his books and
articles on PHP security, Jochen Weiland for an initial foundation and Michael Schams
for compiling the content of the security chapter and coordinating the collaboration between
several teams. He managed the whole process of getting the Security Guide to a high quality.


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


.. _next-steps:

Further Documentation
---------------------

This manual covers many different APIs of the TYPO3 CMS Core, but some
other documents exist which cover more specific aspects.


:ref:`TCA Reference <t3tca:start>`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

`TCA` is the backbone of database tables displayed in the backend, it configures
how data is stored if editing records in the backend, how fields are displayed,
relations to other tables and much more. It is a huge array loaded in almost all
access contexts.

A detailed insight on `TCA` is documented in the :ref:`TCA Reference <t3tca:start>`.
Next to a small introduction, the document forms a complete reference of all
different `TCA` options, with bells and whistles. The document is a must-read for
Developers, partially for Integrators, and is often used as a reference book on a daily basis.


:ref:`TypoScript Reference <t3tsref:start>`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

`TypoScript` - or more precisely `Frontend TypoScript` - is used in TYPO3 to steer
the frontend rendering (the actual website) of a TYPO3 instance. It is based on the
TypoScript syntax which is outlined in detail :ref:`here in this document <typoscript-syntax-start>`.

Frontend TypoScript is very powerful and has been the backbone of frontend rendering ever since.
However, with the rise of the Fluid templating engine, many parts of Frontend TypoScript are much less
often used. Nowadays, TypoScript in real life projects is often not much more than a way to
set a series of options for plugins, to set some global config options, and to act as a simple
pre processor between database data and Fluid templates.

Still, the :ref:`TypoScript Reference <t3tsref:start>` reference document that goes deep into
the incredible power of Frontent TypoScript is daily bread for Integrators.


:ref:`TSconfig Reference <t3tsconfig:start>`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

While `Frontend TypoScript` is used to steer the rendering of the frontend, `TSconfig` is used
to configure backend details for backend users. Using `TSconfig` it is possible to enable or
disable certain views, change the editing interfaces, and much more. All that without coding a single
line of PHP. `TSconfig` can be set on a page (Page TSconfig), as well as a user / group (User TSconfig)
basis.

`TSconfig` uses the same syntax as `Frontend TypoScript`, the syntax is outlined in detail
:ref:`here in this document <typoscript-syntax-start>`. Other than that, TSconfig and Frontend TypoScript
don't have much more in common - they consist of entirely different properties.

A full reference of properties as well as an introduction to explain details configuration usage, API and
load orders can be found in the :ref:`TSconfig Reference document <t3tsconfig:start>`. While Developers
should have an eye on this document, it is mostly used as a reference for Integrators who make life as
easy as possible for backend users.


.. _overview:

System Overview
---------------

For most people TYPO3 is equivalent to a CMS providing a backend for
management of the content and a frontend engine for website display.
However the core of TYPO3 is natively designed to be a general purpose
framework for management of database content. The core of TYPO3 CMS
delivers a set of principles for storage of this content, user access
management, editing of the content, uploading and managing files, etc.
These principles are expressed as an API (Application
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


.. _installation:

A basic installation
--------------------

To follow this document, it might help to have a totally trimmed down installation
of TYPO3 CMS with *only* the core and the required system extensions at hand.

The installation process is covered in the :ref:`Installation and Upgrade Guide <t3install:start>`.
You should perform the basic installation steps and not install any distribution.
This will give you the "lightest" possible version of TYPO3 CMS.

Log into your basic installation and move to the **ADMIN TOOLS > Extensions**
module. You will see all extensions which are loaded by default.
Required extensions are not only loaded by default, they have no
"Activate/Deactivate" button, too.

.. figure:: ../Images/ExtensionsMinimalList.png
   :alt: The Extension Manager with a bare bones installation


The most important thing to note for now is that **everything** is an
extension in TYPO3 CMS. Even the most basic functions are packaged in a
system extension called "core".
