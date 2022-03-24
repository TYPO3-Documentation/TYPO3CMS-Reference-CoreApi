.. include:: /Includes.rst.txt

.. _about:

=================
About This Manual
=================


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

Intended Audience
=================

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
=============

Many of the code examples found in this document come from the TYPO3
Core itself.

Quite a few others come from the "`styleguide <https://github.com/TYPO3/styleguide>`__"
extension. You can install it, if you want to try out these examples yourself and
use them as a basis for your own extensions.

.. _contribute:
.. _feedback:

Feedback and Contribute
=======================

If you find an error in this manual, please be so kind to hit
the "Edit me on GitHub" button in the top right corner
and submit a pull request via GitHub.

Alternatively you can just `report an issue
on GitHub <https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/new>`__.

You can find more about this in Writing Documentation:

- :ref:`h2document:docs-contribute` : Make a change by editing directly on
  GitHub and creating a pull request
- :ref:`h2document:docs-contribute-git-docker` : If you are experienced
  with Docker and Git you can edit and render locally.

If you are currently not reading the online version, go to
https://docs.typo3.org/typo3cms/CoreApiReference/.

Maintaining high quality documentation requires time and effort
and the TYPO3 Documentation Team always appreciates support.

If you want to support us, please join the slack channel **#typo3-documentation**
on `Slack <https://typo3.slack.com/>`__ (`Register for Slack <https://my.typo3.org/about-mytypo3org/slack/>`__).

And finally, as a last resort, you can get in touch with the documentation team
`by mail <documentation@typo3.org>`_.


.. _credits:

Credits
=======

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
==========

I want to dedicate this document to the people in the TYPO3 community
who have the  *discipline* to do the boring job of writing
documentation for their extensions or contribute to the TYPO3
documentation in general. It's great to have good coders, but it's
even more important to have coders with character to carry their work
through till the end - even when it means spending days writing good
documents. Go for completeness!

\- kasper


Further Documentation
=====================

This manual covers many different APIs of the TYPO3 CMS Core, but some
other documents exist which cover more specific aspects.


:doc:`TCA Reference <t3tca:Index>`
----------------------------------

`TCA` is the backbone of database tables displayed in the backend, it configures
how data is stored if editing records in the backend, how fields are displayed,
relations to other tables and much more. It is a huge array loaded in almost all
access contexts.

A detailed insight on `TCA` is documented in the :doc:`TCA Reference <t3tca:Index>`.
Next to a small introduction, the document forms a complete reference of all
different `TCA` options, with bells and whistles. The document is a must-read for
Developers, partially for Integrators, and is often used as a reference book on a daily basis.


:doc:`TypoScript Reference <t3tsref:Index>`
-------------------------------------------

`TypoScript` - or more precisely `Frontend TypoScript` - is used in TYPO3 to steer
the frontend rendering (the actual website) of a TYPO3 instance. It is based on the
TypoScript syntax which is outlined in detail :ref:`here in this document <typoscript-syntax-start>`.

Frontend TypoScript is very powerful and has been the backbone of frontend rendering ever since.
However, with the rise of the Fluid templating engine, many parts of Frontend TypoScript are much less
often used. Nowadays, TypoScript in real life projects is often not much more than a way to
set a series of options for plugins, to set some global config options, and to act as a simple
pre processor between database data and Fluid templates.

Still, the :doc:`TypoScript Reference <t3tsref:Index>` reference document that goes deep into
the incredible power of Frontend TypoScript is daily bread for Integrators.


:doc:`TSconfig Reference <t3tsconfig:Index>`
--------------------------------------------

While `Frontend TypoScript` is used to steer the rendering of the frontend, `TSconfig` is used
to configure backend details for backend users. Using `TSconfig` it is possible to enable or
disable certain views, change the editing interfaces, and much more. All that without coding a single
line of PHP. `TSconfig` can be set on a page (Page TSconfig), as well as a user / group (User TSconfig)
basis.

`TSconfig` uses the same syntax as `Frontend TypoScript`, the syntax is outlined in detail
:ref:`here in this document <typoscript-syntax-start>`. Other than that, TSconfig and Frontend TypoScript
don't have much more in common - they consist of entirely different properties.

A full reference of properties as well as an introduction to explain details configuration usage, API and
load orders can be found in the :doc:`TSconfig Reference document <t3tsconfig:Index>`. While Developers
should have an eye on this document, it is mostly used as a reference for Integrators who make life as
easy as possible for backend users.
