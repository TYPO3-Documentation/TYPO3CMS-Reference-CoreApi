.. include:: /Includes.rst.txt
.. index:: !Backend layout
.. _be-layout:

==============
Backend layout
==============

Backend layouts can be defined as database records or via :ref:`page TSconfig <t3tsref:pagetsconfig>`.
Page TSconfig should be preferred as it can be stored in the file system and
be kept under version control.

.. _be-layout-video:

Backend layout video
====================

Benjamin Kott: How to implement frontend layouts in TYPO3 using backend layouts

.. youtube:: RoHaeo4fq34

.. index::
   Backend layout; Info module
   Backend layout; Configuration
.. _be-layout-info-module:

Backend layout configuration
=============================

The backend layout to be used can be configurated for each page and/or a pages'
subpages in the :guilabel:`Page properties > Appearance`. Multiple backend
layouts are available if an
:ref:`extension providing backend layouts<be-layout-extensions>` is installed or
backend layouts have been
:ref:`defined as records or page TSconfig <be-layout-definition>`.

.. include:: /Images/AutomaticScreenshots/BackendLayouts/PagePropertiesAppearance.rst.txt

The Info module gives an overview of the backend layouts configured or
inherited from a parent page at
:guilabel:`Web > Info > Pagetree overview > Type: Layouts`:

.. include:: /Images/AutomaticScreenshots/BackendLayouts/PageTreeLayoutOverview.rst.txt

.. index::
   Backend layout; Record
   Backend layout; TSconfig
.. _be-layout-definition:

Backend layout definition
=========================

Backend layouts can be configured either as "backend layout" record in a sysfolder or as page TSconfig entry in
:typoscript:`mod.web_layout.BackendLayouts`. Each layout will be saved with a key. The "backend layout" records are
using their uid as a key, therefore layouts defined via page TSconfig should use a non-numeric string key. It is a good
practice to use a descriptive name as key.

The entries title and icon are being used to display the backend layout options in the page properties.

The overall grid size will be defined by :typoscript:`config.backend_layout.colCount` and :typoscript:`rowCount`.
Additional rows in the :typoscript:`rows` array and additional columns in the each rows :typoscript:`columns` section
will be ignored when they are greater than :typoscript:`rowCount` or :typoscript:`colCount` respectively.

Each column position can span several columns and or several rows. Each column position must have a distinct number
between 0 and n. It is best practice to always assign "0" to the main column if there is such a thing as a
main column. Multiple backend layouts that contain similar parts, i.e. header, footer, aside, ...  should each have
assigned the same number within one project. This leads to a uniform position of the content, which makes it more clear
for further use.

.. index:: Backend layout; Example
.. _be-layout-simple-example:

Backend layout simple example
=============================

The following page TSconfig example creates a simple backend layout consisting of two rows and just one column.

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

Backend layout advanced example
===============================

The following page TSconfig example creates a 3x3 backend layout with 5 column position sections in total. The topmost
row (here called "header") spans all 3 columns. There is an "aside" spanning two rows on the right.

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

Output of a backend layout in the frontend
==========================================

The backend layout to be used on a certain page gets determined either by the backend layout being chosen directly and
stored in the pages field "backend_layout" or by the field "backend_layout_next_level" of a parent page up the rootline.

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

In the Fluid template the column positions can be accessed now via content mapping as described here
:ref:`t3sitepackage:content-mapping`.


.. index:: Backend layout; Reference implementation
.. _be-layout-reference-implementations:

Reference implementations of backend layouts
============================================

The extension :composer:`bk2k/bootstrap-package` ships several
`Backend layouts <https://github.com/benjaminkott/bootstrap_package/tree/1b00a01e362d2460af92f754ee10e507edb70568/Configuration/TsConfig/Page/Mod/WebLayout/BackendLayouts>`__
as well as an example configuration of how to include frontend templates for backend layouts (see its
`setup.typoscript <https://github.com/benjaminkott/bootstrap_package/blob/1b00a01e362d2460af92f754ee10e507edb70568/Configuration/TypoScript/setup.typoscript#L99-L113>`__)

.. index:: pair: Backend layout; Extensions
.. _be-layout-extensions:

Extensions for backend layouts
==============================

In many cases besides defining fixed backend layouts a more modular approach with the possibility of combining different
backend layouts and frontend layouts may be feasible. The extension
:composer:`b13/container`
integrates the grid layout concept also to regular content elements.

The extension :composer:`ichhabrecht/content-defender` offers advanced options to
the column positions i.e. allowed or disallowed content elements, a maximal number of content elements.
