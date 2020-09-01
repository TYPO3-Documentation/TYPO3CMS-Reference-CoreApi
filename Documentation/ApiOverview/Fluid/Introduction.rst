.. include:: ../../Includes.txt

.. highlight:: xml

.. _fluid-introduction:

=====================
Introduction to Fluid
=====================

Fluid is TYPO3’s default rendering engine but can also be used in a standalone PHP project.
The Fluid source code is being developed as an independent project outside of the TYPO3 core.

Fluid is based on XML.
You can use HTML markup in Fluid, but you can do much more with Fluid, such as use conditions,
variables or custom ViewHelpers which are PHP components.

Example Fluid snippet
=====================

This is how a simple Fluid snippet could look like::

   <h4>This is your headline</h4>
   <p>
    <f:if condition="{myExpression}">
      <f:then>
         {somevariable}
      </f:then>
      <f:else>
          {someothervariable}
      </f:else>
    </f:if>
   </p>

The resulting HTML may look like this::

   <h4>This is your headline</h4>
   <p>This is the content of variable "somevariable"</p>

The above Fluid snippet contains:

ViewHelpers:
   The XML elements that start with `f:` like `<f:if>` etc. are ViewHelpers. These
   are PHP components that are supplied by Fluid and can be used in your Fluid templates.
   TYPO3 adds some more ViewHelpers for TYPO3 specific functionality. And, you can
   :ref:`write your own <t3extbasebook:developing-a-custom-viewhelper>`.

   ViewHelpers can do simple processing such as remove spaces with the
   :ref:`t3viewhelper:typo3fluid-fluid-spaceless` ViewHelper or create a link
   as is done in the TYPO3 Fluid ViewHelper :ref:`t3viewhelper:typo3-fluid-link-page`.

Object Accessors:
   Fluid can access variables that have been defined. Just use braces
   and the name of the variable: `{somevariable}`. In Fluid, these placeholders
   are called `Object Accessors`.

Conditions:
    The conditions are supplied here by the if / then / else ViewHelpers.

Directory structure
===================

In your extension, the following directory structure should be used for Fluid files:

.. code-block:: none

   ── Resources
      └── Private
        ├── Layouts
        ├── Partials
        └── Templates

This directory structure is the convention used by TYPO3 CMS. When using Fluid outside of
TYPO3 CMS you can use any folder structure you like.

If you are using Extbase controller actions in combination with Fluid,
Extbase defines how files and directories should be named within these directories.
Extbase uses sub directories located within the "Templates" directory to group
templates by controller name and the filename of templates to correspond to a
certain action on that controller
(see :ref:`t3extbasebook:template-creation-by-example`).

.. code-block:: none

   └── Resources
       └── Private
           └── Templates
               └── Blog
                   ├── List.html (for Blog->list() action)
                   └── Show.html (for Blog->show() action)


If you don't use Extbase you can still use this convention, but it is not a
requirement to use this structure to group templates into logical groups, such
as "Page" and "Content" to group different types of templates.

In Fluid, the location of these paths is defined with
:php:`\TYPO3Fluid\Fluid\Core\Rendering\RenderingContext->setTemplatePaths()`.

TYPO3 provides the possibility to set the paths using TypoScript.


:file:`Templates`
-----------------

The template contains the main Fluid template. When using a layout (this is optional),
you must define the sections that are referenced by the layout.

:file:`Layouts`
---------------

*optional*

Layouts serve as a wrapper for a web page or a specific block of content. If using Fluid
for a sitepackage, a single layout file will often contain multiple components such as your
sites menu, footer, and any other items that are reused throughout your website.

Templates can be used with or without a Layout.

* *With a Layout* anything that's not inside a section is ignored. When a
  Layout is used,   the Layout determines which sections will be rendered
  from the template through the use of   :xml:`<f:render>` in the Layout file.
* *Without a Layout* anything that's not inside a section is rendered. You
  can still use sections of course, but you then must use f:render in the
  template file itself, outside of a section, to render a section.

:file:`Partials`
----------------

*optional*

Partials are a Fluid component. Partials can be used as reusable components from within
a template.

Example: Using Fluid to create a theme
======================================

This example was taken from the `example extension <https://github.com/TYPO3-Documentation/TYPO3CMS-Tutorial-SitePackage-Code/>`__
for :ref:`t3sitepackage:start` and reduced to a very basic example.

The Sitepackage Tutorial walks you through the creation of a sitepackage
(theme) using Fluid. In our simplified example, the overall structure of
a page is defined by a layout "Default". We show an example of a three
column layout. Further templates can be added later, using the same layout.

.. code-block:: none

   Resources/
   └── Private
       ├── Layouts
       │   └── Page
       │       └── Default.html
       ├── Partials
       │   └── Page
       │       └── Jumbotron.html
       └── Templates
           └── Page
               └── ThreeColumn.html


Set the Fluid paths with TypoScript using :ref:`t3tsref:cobj-fluidtemplate`

.. code-block:: typoscript

   lib.dynamicContent = COA
   lib.dynamicContent {
      10 = LOAD_REGISTER
      10.colPos.cObject = TEXT
      10.colPos.cObject {
         field = colPos
         ifEmpty.cObject = TEXT
         ifEmpty.cObject {
            value.current = 1
            ifEmpty = 0
         }
      }
      20 = CONTENT
      20 {
         table = tt_content
         select {
            orderBy = sorting
            where = colPos={register:colPos}
            where.insertData = 1
         }
      }
      90 = RESTORE_REGISTER
   }

   page = PAGE
   page {
      // Part 1: Fluid template section
      10 = FLUIDTEMPLATE
      10 {
         templateName = Default
         templateRootPaths {
            0 = EXT:site_package/Resources/Private/Templates/Page/
         }
         partialRootPaths {
            0 = EXT:site_package/Resources/Private/Partials/Page/
         }
         layoutRootPaths {
            0 = EXT:site_package/Resources/Private/Layouts/Page/
         }
      }
   }

:file:`Resources/Private/Layouts/Page/Default.html`::

   <f:render section="Header" />
   <f:render section="Main" />
   <f:render section="Footer" />


:file:`Resources/Private/Templates/Page/ThreeColumn.html`:

.. code-block:: xml
   :linenos:

   <f:layout name="Default" />

   <f:section name="Header">
      <!-- add header here ! -->
   </f:section>

   <f:section name="Main">
      <f:render partial="Jumbotron" />
       <div class="container">
         <div class="row">
           <div class="col-md-4">
             <f:cObject typoscriptObjectPath="lib.dynamicContent" data="{colPos: '1'}" />
           </div>
           <div class="col-md-4">
             <f:cObject typoscriptObjectPath="lib.dynamicContent" data="{colPos: '0'}" />
           </div>
           <div class="col-md-4">
             <f:cObject typoscriptObjectPath="lib.dynamicContent" data="{colPos: '2'}" />
           </div>
         </div>
       </div>
   </f:section>

   <f:section name="Footer">
       <!-- add footer here ! -->
   </f:section>

* The template uses the layout "Default". It must then define all sections that the layout
  requires: "Header", "Main" and "Footer".
* In the section "Main", a partial "Jumbotron" is used.
* The template makes use of column positions (colPos). The content elements for each section
  on the page will be rendered into the correct `div`. Find out more about this in :ref:`be-layout`.
* Again, we are using Object Accessors to access data (e.g. `{colPos: '2'}`) that has been
  generated elsewhere.


:file:`Resources/Private/Partials/Page/Jumbotron.html`::

   <div class="jumbotron">
      <div class="container">
         <h1 class="display-3">Hello, world!</h1>
         <p> some text </p>
      </div>
   </div>



Further information
===================

To get an introduction to the basics of Fluid:

* `The Fluid Syntax <https://github.com/TYPO3/Fluid/blob/master/doc/FLUID_SYNTAX.md>`__
* `ViewHelpers - what these classes do in the Fluid language <https://github.com/TYPO3/Fluid/blob/master/doc/FLUID_VIEWHELPERS.md>`__

Depending on what you plan to do, you may want to follow one of these comprehensive
tutorials:

* :ref:`t3sitepackage:start` which shows you how to create a theme for your site
  using Fluid.
* :ref:`Create custom content elements <adding-your-own-content-elements>`
* :ref:`t3extbasebook:start`
* Use Fluid to create emails using the :ref:`TYPO3 Mail API <mail-fluid-email>`

Once you have successfully completed your fist steps, these references might come
in handy:

* `24 TIPS & TRICKS FOR FLUID <https://usetypo3.com/24-fluid-tips.html>`__
* :ref:`Fluid ViewHelper Reference <t3viewhelper:start>`


