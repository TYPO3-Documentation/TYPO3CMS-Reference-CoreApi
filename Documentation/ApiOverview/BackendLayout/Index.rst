.. include:: /Includes.rst.txt

.. _be-layout:

==============
Backend Layout
==============

Since TYPO3 4.5 there has been a database record type the "Backend Layout" to define a combination of rows and columns
to which content can be added in the page module.

With TYPO3 7.4 a new feature was introduced to define backend layouts in TYPO3 via PageTSConfig. It implements a
generic PageTS provider for backend layouts to make backend layouts reusable across installations.

.. _be-layout-video:

Backend Layout Video
================================

Benji: How to implement frontend layouts in TYPO3 using backend layouts

.. youtube:: RoHaeo4fq34


.. _be-layout-definition:

Backend Layout Definition
=========================

Backend Layouts can be configured either as "Backend Layout" record in a sysfolder or as PageTsConfig entry in
:typoscript:`mod.web_layout.BackendLayouts`. Each layout will be saved with a key. The Backend Layout records are
using their uid as a key, therefore layouts defined via PageTsConfig should use a non-numeral String key. It is a good
practise to use a descriptive name as key.

The entries title and icon are being used to display the Backend Layout options in the page properties.

The overall grid size will be defined by :typoscript:`config.backend_layout.colCount` and :typoscript:`rowCount`.
Additional rows in the :typoscript:`rows` Array and additional columns in the each rows :typoscript:`columns` section
will be ignored when they are greater then :typoscript:`rowCount` or :typoscript:`colCount` respectively.

Each column position can span several columns and or several rows. Each column position must have a distinct number
between 0 and n assigned. It is best practise to always assign "0" to the main column if there is such a thing as a
main column. Multiple Backend Layouts that contain similar parts, i.e. header, footer, aside, ... should within one
project have the same number assigned each. This simplifies sliding up to find content within one column position to
use content of a parent page across layouts.


.. _be-layout-simple-example:

Backend Layout Simple Example
=============================

The following PageTsConfig example creates a simple Backend Layout consisting of two rows and just one Columns.

.. code-block:: typoscript

   mod {
     web_layout {
       BackendLayouts {
         exampleKey {
           title = Example
           config {
             backend_layout {
               colCount = 1
               rowCount = 2
               rows {
                 1 {
                   columns {
                     1 {
                       name = LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:colPos.I.3
                       colPos = 3
                       colspan = 1
                     }
                   }
                 }
                 2 {
                   columns {
                     1 {
                       name = Main
                       colPos = 0
                       colspan = 1
                     }
                   }
                 }
               }
             }
           }
           icon = EXT:example_extension/Resources/Public/Images/BackendLayouts/default.gif
         }
       }
     }
   }

.. _be-layout-advanced-example:

Backend Layout Advanced Example
===============================

The following PageTsConfig example creates a 3x3 Backend Layout with 5 column position sections in total. The topmost
row, the "Header" spans all 3 columns. There is an "Aside" spanning two rows on the right.

.. code-block:: typoscript

   mod.web_layout.BackendLayouts {
     exampleKey {
       title = Example
       icon = EXT:example_extension/Resources/Public/Images/BackendLayouts/default.gif
       config {
         backend_layout {
           colCount = 3
           rowCount = 3
           rows {
             1 {
               columns {
                 1 {
                   name = Header
                   colspan = 3
                   colPos = 1
                 }
               }
             }
             2 {
               columns {
                 1 {
                   name = Main
                   colspan = 2
                   colPos = 0
                 }
                 2 {
                   name = Aside
                   rowspan = 2
                   colPos = 2
                 }
               }
             }
             3 {
               columns {
                 1 {
                   name = Main Left
                   colPos = 5
                 }
                 2 {
                   name = Main Right
                   colPos = 6
                 }
               }
             }
           }
         }
       }
     }
   }


.. _be-layout-frontend:

Output of a Backend Layout in the frontend
==========================================

The backend layout to be used on a certain page gets determined either by the backend layout being chosen directly and
stored in the pages field "backend_layout" or by the field "backend_layout_next_level" of a parent page up the rootline

To avoid complex TypoScript for integrators, the handling of backend layouts has
been simplified for the frontend.

To get the correct backend layout, the following TypoScript code can be used:

.. code-block:: typoscript

	page.10 = FLUIDTEMPLATE
	page.10 {
	  file.stdWrap.cObject = CASE
	  file.stdWrap.cObject {
		key.data = pagelayout

		default = TEXT
		default.value = EXT:sitepackage/Resources/Private/Templates/Home.html

		3 = TEXT
		3.value = EXT:sitepackage/Resources/Private/Templates/1-col.html

		4 = TEXT
		4.value = EXT:sitepackage/Resources/Private/Templates/2-col.html
	  }
	}

Using  `data = pagelayout` is the same as using as

.. code-block:: typoscript

	field = backend_layout
	ifEmpty.data = levelfield:-2,backend_layout_next_level,slide
	ifEmpty.ifEmpty = default

In the fluid template the column positions can be accessed now via content mapping as described here
:ref:`t3sitepackage:content-mapping`.


.. _be-layout-extensions:

Extensions for the Backend Layouts
==================================

In many cases beside defining fixed Backend Layouts a more modular approach may be feasible Where different layouts in
Backend and Frontend can be combined. The extension `gridelements <https://extensions.typo3.org/extension/gridelements/>`__
integrates the grid layout concept also to regular content elements.

The extension `content_defender <https://extensions.typo3.org/extension/content_defender/>`__ offers advanced options to
the column positions i.e. allowed or disallowed content elements, a maximal number of contend elements.


