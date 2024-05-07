.. include:: /Includes.rst.txt
.. highlight:: xml
.. _fluid-introduction:

=====================
Introduction to Fluid
=====================

Fluid is TYPO3’s default rendering engine but can also be used in standalone PHP projects.
The `Fluid source code <https://github.com/TYPO3/Fluid>`__ is being developed as an
independent project outside of the TYPO3 Core.

Fluid is based on XML and you can use HTML markup in Fluid.

Fluid ViewHelpers can be used for various purposes. Some transform data, some include
Partials, some loop over data or even set variables. You can find a complete list of
them in the :ref:`ViewHelper Reference <t3viewhelper:start>`.

You can :ref:`write your own custom ViewHelper <fluid-custom-viewhelper>`,
which is a PHP component.

Example Fluid snippet
=====================

This is how a simple Fluid snippet could look like:

.. code-block:: html
   :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

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

The resulting HTML may look like this:

.. code-block:: html
   :caption: Example frontend output

   <h4>This is your headline</h4>
   <p>This is the content of variable "somevariable"</p>

The above Fluid snippet contains:

ViewHelpers:
   The XML elements that start with `f:` like `<f:if>` etc. are standard ViewHelpers.
   It is also possible to define custom ViewHelpers, for example
   `<foo:bar foo="bar">`. A corresponding file `ViewHelpers/BarViewHelper.php`
   with the methods `initializeArguments` and `render` contains the HTML generation logic.
   ViewHelpers are Fluid components which make a function call to PHP from inside of a template.
   TYPO3 adds some more ViewHelpers for TYPO3 specific functionality.

   ViewHelpers can do simple processing such as remove spaces with the
   :ref:`t3viewhelper:typo3fluid-fluid-spaceless` ViewHelper or create a link
   as is done in the TYPO3 Fluid Viewhelper :ref:`t3viewhelper:typo3-fluid-link-page`.

Expressions, variables:
   Fluid uses placeholders to fill content in specified areas in the template
   where the result is rendered when the template is evaluated. Content within
   braces (for example :html:`{somevariable}`) can contain variables or expressions.

Conditions:
    The conditions are supplied here by the if / then / else ViewHelpers.


.. index:: Fluid; Directory structure

.. _fluid-directory-structure:

Directory structure
===================

In your extension, the following directory structure should be used for Fluid files:

.. code-block:: none

   ── Resources
      └── Private
        ├── Layouts
        ├── Partials
        └── Templates

This directory structure is the convention used by TYPO3. When using Fluid outside of
TYPO3 you can use any folder structure you like.

If you are using Extbase controller actions in combination with Fluid,
Extbase defines how files and directories should be named within these directories.
Extbase uses sub directories located within the "Templates" directory to group
templates by controller name and the filename of templates to correspond to a
certain action on that controller.

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

.. _fluid-templates:

:file:`Templates`
-----------------

The template contains the main Fluid template.

.. _fluid-layouts:

:file:`Layouts`
---------------

*optional*

Layouts serve as a wrapper for a web page or a specific block of content. If using Fluid
for a sitepackage, a single layout file will often contain multiple components such as your
sites menu, footer, and any other items that are reused throughout your website.

Templates can be used with or without a Layout.

* *With a Layout* anything that's not inside a section is ignored. When a
  Layout is used, the Layout determines which sections will be rendered
  from the template through the use of :xml:`<f:render>` in the Layout file.
* *Without a Layout* anything that's not inside a section is rendered. You
  can still use sections of course, but you then must use f:render in the
  template file itself, outside of a section, to render a section.

For example, the layout may like this

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Layouts/Default.html

   <div class="header">
      <f:render section="Header" />
   </div>
   <div class="main">
      <f:render section="Main" />
   </div>

The layout defines which sections are rendered and in which order. It can
contain additional arbitrary Fluid / HTML. How you name the sections and which
sections you use is up to you.

The corresponding template should include the sections which are to be rendered.

.. code-block:: html
   :caption:  EXT:my_extension/Resources/Private/Templates/Default.html

   <f:layout name="Default" />

   <f:section name="Header">
      <!-- add header here ! -->
   </f:section>

   <f:section name="Main">
      <!-- add main content here ! -->
   </f:section>


.. _fluid-partials:

:file:`Partials`
----------------

*optional*

Some parts within different templates might be the same. To not repeat this part
in multiple templates, Fluid offers so-called partials. Partials are small pieces
of Fluid template within a separate file that can be included in multiple templates.

Partials are stored, by convention, within :file:`Resources/Private/Partials/`.

Example partial:

.. code-block:: html
   :caption:  EXT:my_extension/Resources/Private/Partials/Tags.html

   <b>Tags</b>:
   <ul>
      <f:for each="{tags}" as="tag">
         <li>{tag}</li>
      </f:for>
   </ul>

Example template using the partial:

.. code-block:: html
   :caption:  EXT:my_extension/Resources/Private/Templates/Show.html

   <f:render partial="Tags" arguments="{tags: post.tags}" />

The variable :html:`post.tags` is passed to the partial as variable :html:`tags`.

If ViewHelpers from a different namespace are used in the partial, the namespace
import can be done in the template or the partial.

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


.. code-block:: html
   :caption: Resources/Private/Layouts/Page/Default.html

   <f:render section="Header" />
   <f:render section="Main" />
   <f:render section="Footer" />


.. code-block:: html
   :caption: Resources/Private/Templates/Page/ThreeColumn.html

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


.. code-block:: html
   :caption: Resources/Private/Partials/Page/Jumbotron.html

   <div class="jumbotron">
      <div class="container">
         <h1 class="display-3">Hello, world!</h1>
         <p> some text </p>
      </div>
   </div>
