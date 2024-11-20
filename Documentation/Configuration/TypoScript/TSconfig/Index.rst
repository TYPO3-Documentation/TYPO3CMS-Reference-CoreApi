.. include:: /Includes.rst.txt
.. index:: TSconfig
.. _tsconfig:

========
TSconfig
========

"user TSconfig" and "page TSconfig" are very flexible concepts for
adding fine-grained configuration to the TYPO3 backend. It is a text-based
configuration system where you assign values to keyword strings,
using the TypoScript syntax. The
:ref:`Page TSconfig Reference <t3tsref:pagetoplevelobjects>` and
:ref:`User TSconfig reference <t3tsref:usertoplevelobjects>`
describe in detail how this works and what can be done with it.


.. index::
   User TSconfig
   TSconfig; User
.. _tsconfig-user:

User TSconfig
=============

User TSconfig can be set for backend users and groups.
Configuration set for backend groups is inherited by the user who is a
member of those groups. The available options typically cover user
settings like those found in the :guilabel:`User Settings` module, various backend tweaks
(lock user to IP, may user clear caches?, etc.) and backend module configuration.


.. index::
   Page TSconfig
   TSconfig; Page
.. _tsconfig-page:

Page TSconfig
=============

Page TSconfig can be set for each page in the page tree. Pages
inherit configuration from parent pages. The available
options typically cover backend module configuration, which means that
modules related to pages can be configured for different behaviours in different
branches of the tree.

It also includes configuration for the :ref:`FormEngine <FormEngine>` (Forms
to edit content in TYPO3) and the :ref:`DataHandler <datahandler-basics>`
(component that takes care of transforming and persisting data
structures) behaviours. Again, the point is that the configuration is
active for certain branches of the page tree which is useful
in projects running many sites in the same page tree.
