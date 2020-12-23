.. include:: /Includes.rst.txt
.. index:: TypoScript; Contexts
.. _typoscript-syntax-typoscript-contexts:

========
Contexts
========

There are two contexts where `TypoScript`:pn: is used: templates, where
`TypoScript`:pn: is used to actually define what will appear in the `TYPO3 CMS`:pn:
frontend, and `TSconfig`:pn:, where it is used to configure settings of the
`TYPO3`:pn: backend. `TSconfig`:pn: is further subdivided into **user `TSconfig`:pn:**
(defined for backend users or user groups) and **page `TSconfig`:pn:** (defined
for pages in the page tree).

Page `TSconfig`:pn: is used for customizing the `TYPO3 CMS`:pn: backend according
to where users will be working along the page tree. User `TSconfig`:pn:
is used to customize what elements are visible for users and groups
or change the behavior of some elements.

Some parts of `TypoScript`:pn: are available in both contexts, some only in
one or the other. Any difference is mentioned at the relevant place.

Each context has its own chapter in this manual. It also has its own
reference in a separate manual (see :ref:`typoscript-syntax-next-steps` at the end of
this manual).

.. note::

   `TYPO3 CMS`:pn: provides a :ref:`TypoScript parser <typoscript-syntax-typoscript-parser-api>`
   whose API can be used by any developer. In theory this means that new
   contexts of `TypoScript`:pn: usage can be created by `TYPO3 CMS`:pn: extensions.
