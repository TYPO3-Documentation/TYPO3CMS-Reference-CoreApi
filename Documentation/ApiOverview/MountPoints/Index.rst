.. include:: /Includes.txt
.. index:: Mount points
.. _Mount-points:

============
Mount points
============

.. highlight:: text

.. contents:: This page
   :backlinks: top
   :local:


.. how to write *Words:*
..    mount point, multisite, multi language support, page tree, subpage


What are mount points?
======================

TYPO3 editors can reuse existing pages of the page tree and insert them again
at another location without having to copy anything. To achieve this they
create a new page and set its type to *MountPoint*. Then they select a page as
content source. This is called *mounting*. Note that no pages nor content
elements are copied. Instead, mounting creates a reference to content that is
already maintained elsewhere in the installation. This also means that an
update of that content will be shown in all mounted pages as well.

Mounting may or may not include subpages, depending on what the editor chooses.
It's an option. Various other properties of mounted pages can be specified as
well in the properties of the mount point page. An important option of these is
the one that determines what content should be shown on exactly the mount point
page. This may be the referenced content or the content of mount point page.


Why?
====

*Powerful and indespensible:* Mount points are an indespensible, powerful and
important tool for huge enterprise installations and intranet or extranet
solutions.

*Efficiency:* Mount points allow editors to maintain content only once but
reuse it in various sections of the website. Colors, style and appearance may
vary depending on each rendering context.


Terminology
===========

Mount point
   *Mount point page* is an alias. This is a page (= page record) that has its
   type set to *MountPoint*. This is done by setting field `doktype=7`.
   Another, regular page of the page tree is selected as *content source*. This
   is the "mounted page" or "mounted content". Specifying the mounted page is
   called *mounting*, sometimes also labelled *web mount*. It is an option
   whether **subpages** are included or not.


Mounted page
   An alias for this is *mount target* or *content source*. A mounted page is
   an existing, regular page that serves as content source.


Multisite
   This is a setup of an TYPO3 installation where multiple sites, each with
   their own domain and page tree, share the same installation.


URLs
====

MP parameter
------------

Links to mounted subpages will have a certain construction. An additional GET
parameter `MP` is present and carries mount point information. Usually that
looks like `MP=13-23` which would mean that page 23 is a mount point page
having `doktype = 7` and 13 is the number of the mounted page.


Nested mount points
-------------------

What happens when a mounted page tree already has mount points? This is a case
of *nested mount points.* These is legal and possible. To make it possible
pairs of page IDs are added to the `MP` parameter forming a comma separated
list. *Example:* `MP=13-23,84-26`.


Slug generation
---------------

Since version v9 of TYPO3 `site handling ((link?)) <#>`__ and `slug generation
((link?)) <#>`__ is built in. In TYPO3 a given page can only have *one* string
for representation in a speaking URL. URLs nevertheless need to be unique and
the `MP` get parameter should not be shown. TYPO3 will therefore combine the
slug of the mount point page with the slugs of mounted pages according to some
`((clever)) algorithm ((link?)) <#>`__.


Multisites
==========

((Make this paragraph simpler or more expressive or drop it.)) In cross domain
sites the rendering context of each site is kept while only *the content* is
retrieved from somewhere else. This ensures that the reader will never notice
that content is reused and retrieved from a different site or a different
branch of the page tree.


Considerations and limitations
==============================

.. ordered just alphabetically as there is no hierarchy

Duplicated content and SEO
   Mount points create "duplicate content" by definition. This may work against
   search engine optimisation (SEO) and may need extra consideration.

Menus and linking to mounted subpages
   Think of it: Mounted pages don't have a representation of its own in the
   page tree. This also means that you cannot have links to mounted subpages.
   Instead menus can be used to make mounted subpages accessable. TYPO3 takes
   care of the difficult task of proper menu generation.

Multi language support
   This is possible. All sites have to agree on the same meaning of language
   IDs however.

Slug uniqueness
   Attention: *Slug uniqueness* is NOT garanteed for *multisites*.

   Here is an example to illustrate the reason: Let's say a mount point page
   has the slug `/more` and mounts a page that has a subpage `imprint`. Let's
   further assume the mount page has a sibling `more/imprint` which is a
   regular page. Then there is a collision of a type that TYPO3 cannot detect.
   The regular page will always work but the mounted subpage will never be
   shown.

   ((**TODO:** Though I've rewritten this passage I have to confess that I
   don't really understand this just by reading - marble.))


Examples
========

Example: Simple usage
---------------------

*Intent:* Show an existing part of the page tree a second time at another
location of the tree. Though the mounted pages are generated from the same
content the URLs will be different. And because there may be a different
rendering context, appearance, styles and colors may be different as well.
These underlying mechanisms are not visible to the visitor.

Consider
this setup::

   page   tree
   ====== ====================
   1      Root
   2      ├── Basic MountPoint     <- mount point, mounting page 3
   3      └── Company              <- mounted by page 2
   4          └── About us


Let's assume the mount point page two is configured like this::

   Title         :  Basic MountPoint
   URL segment   :  basic-mountpoint
   Target page   :  Company
   Display option:  "Show the mounted page" (subpages included)


The result will be:

company
   `https://example.com/company/`

   This is just the normal page 3 showing its content.

basic-mountpoint
   `https://example.com/basic-mountpoint/`

   This is the mount point page 2 showing the content of page 3.

about-us
   |  `https://example.com/basic-mountpoint/about-us`
   |  `https://example.com//company/about-us`

   Both URLs will show the same content, namely that of page 4.


Example: Mount points in a multisite
------------------------------------

*Intent:* Show an existing part of the page tree of an arbitrary site a second
time somewhere else. Appearance, styles, colors and even **site** the domain
in the URL may be different.

Situation::

   Page   Tree
   ====== ====================

   1      Site 1: example.com
   2      └── Company              <- mounted by page 5
   3          └── About us

   4      Site 2: company.example.com
   5      └── Cross site mount     <- mount point page that is mounting page 2


Configuration of mount point page 5::

   Title         :  Cross site mount
   URL segment   :  cross-site-mount
   Target page   :  Company
   Display option:  "Show the mounted page" (subpages included)


This will be the result:

company
   |  `https://example.com/company`
   |  `https://company.example.com/cross-site-mount/`

   Both pages were rendered from the same content. They may appear visually
   different though if the sites use different styles.

company/about-us
   |  `https://example.com/company/about-us`
   |  `https://company.example.com/cross-site-mount/about-us`

   Same here: Both pages were rendered from the same content. They may appear
   visually different though if the sites use different styles.


See also
========

Related TypoScript properties:

*  :ref:`config.MP_defaults <t3tsref:setup-config-mp-defaults>`

*  :ref:`config.MP_mapRootPoints <t3tsref:setup-config-mp-maprootpoints>`

*  :ref:`config.MP_disableTypolinkClosestMPvalue
   <t3tsref:setup-config-mp-disabletypolinkclosestmpvalue>`

