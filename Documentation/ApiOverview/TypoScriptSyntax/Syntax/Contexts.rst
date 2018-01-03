.. include:: ../../../Includes.txt


.. _typoscript-syntax-typoscript-contexts:

Contexts
^^^^^^^^

There are two contexts where TypoScript is used: templates, where
TypoScript is used to actually define what will appear in the TYPO3 CMS
frontend, and TSconfig, where it is used to configure settings of the
TYPO3 backend. TSconfig is further subdivided into **User TSconfig**
(defined for backend users or user groups) and **Page TSconfig** (defined
for pages in the page tree).

Page TSconfig is used for customizing the TYPO3 CMS backend according
to where users will be working along the page tree. User TSconfig
is used to customize what elements are visible for users and groups
or change the behavior of some elements.

Some parts of TypoScript are available in both contexts, some only in
one or the other. Any difference is mentioned at the relevant place.

Each context has its own chapter in this manual. It also has its own
reference in a separate manual (see :ref:`typoscript-syntax-next-steps` at the end of
this manual).

.. note::

   TYPO3 CMS provides a :ref:`TypoScript parser <typoscript-syntax-typoscript-parser-api>`
   whose API can be used by any developer. In theory this means that new
   contexts of TypoScript usage can be created by TYPO3 CMS extensions.
