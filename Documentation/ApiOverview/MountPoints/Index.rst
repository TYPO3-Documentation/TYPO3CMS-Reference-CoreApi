.. include:: /Includes.rst.txt
.. index:: Mount points


.. _MountPoints:

============
Mount Points
============

Mount points allow TYPO3 editors to mount a page (and its subpages) from a different
area in the current page tree.

The definitions are as follows:

- Mount Point: A page with `doktype` set to 7 - a page pointing to a different page
  ("web mount") that should act as a replacement for this page and possible descendants.
- Mounted Page, a.k.a. "Mount Target": A regular page containing content and subpages.

The idea behind it is to manage content only once and "link" / "mount" to a tree
to be used multiple times - while keeping the website visitor under the impression
to navigate just a regular subpage. There are concerns regarding SEO for having duplicate content,
but TYPO3 can be used for more than just simple websites, as mount points are an important tool
for massive multi-site installations or Intranet/Extranet installations.

A mount point has the option to either display the content of the mount point
itself or the content of the target page when visiting this page.

Due to TYPO3's principles of slug handling where a page contains one single slug
containing the whole URL path of that page, TYPO3 will combine the slug of the
mount point and a smaller part of the Mounted Page or subpages of the Mounted Page,
which will be added to the URL string.

Mounted subpages don't have a representation of their own in the
page tree, meaning they cannot be linked directly. However, the TYPO3 menu
generation will take mount points into account and generate subpage links
accordingly.

.. note::

   **Technical Background**:

   Linking to a subpage will result in adding "MP" GET Parameters and altering the root
   line (tree structure) of the website, as the "MP" is containing the context.
   The MP parameter found throughout the TYPO3 Core includes the ID of the Mounted Page and
   the mount point ID - e.g. "13-23," whereas 13 would be the Mounted Page and 23
   the mount point (`doktype` set to 7).

   Recursive mount points are added to the "MP" parameter with ",", like "13-23,84-26".
   Recursive mount points are defined as follows: A Mounted Page has a subpage
   which in turn has another subpage, which is again a mount point. (Nested mount points.)


Simple usage example
====================

Consider this setup::

   page   tree
   ====== ====================
   1      Root
   2      ├── Basic Mount Point    <- mount point, mounting page 3
   3      └── Company              <- mounted by page 2
   4          └── About us

Let's assume the mount point page two is configured like this::

   Title         :  Basic Mount Point
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
   |  `https://example.com/company/about-us`

   Both URLs will show the same content, namely that of page 4.


Multi-Site support
==================

Mount points generally support cross-site mounts. The context for cross-domain
sites is kept, ensuring that the user will never notice that content might be coming
from a completely different site or pagetree within TYPO3.

Creating links for multi-site mount points works the same way as in a
same site setup.

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

   Both pages are rendered from the same content. They may appear visually
   different though if the sites use different styles.

company/about-us
   |  `https://example.com/company/about-us`
   |  `https://company.example.com/cross-site-mount/about-us`

   Same here: Both pages are rendered from the same content. They may appear
   visually different though if the sites use different styles.


Limitations
===========

1. *Multi-language support*

   Please be aware that multi-language setups are generally supported, but this
   only works if both sites use the same language IDs (for example, you cannot
   combine a site with a configured language ID 13 with a site using only ID 1).

2. *Slug uniqueness when using Multi-Site setups cannot be ensured*

   If a Mount Point Page has the slug "/more", mounting a page with "/imprint" subpage,
   but the Mount Point Page has a regular sibling page with "/more/imprint" a collision cannot
   be detected. In contrast, the non-mounted page would always work, and a subpage of a
   Mounted Page would never be reached.::

      Page   Tree
      ====== ====================

      1      Site 1: example.com
      2      └── More              <- mounted by page 5
      3          └── Imprint       <- page will never be reached via Site 2

      4      Site 2: company.example.com
      5      └── More              <- mount point page that is mounting page 2
      6      └── Imprint           <- slug manually configured to `more/imprint/`


See also
========

Related TypoScript properties:

* :ref:`config.MP_defaults <t3tsref:setup-config-mp-defaults>`

* :ref:`config.MP_mapRootPoints <t3tsref:setup-config-mp-maprootpoints>`

* :ref:`config.MP_disableTypolinkClosestMPvalue <t3tsref:setup-config-mp-disabletypolinkclosestmpvalue>`

