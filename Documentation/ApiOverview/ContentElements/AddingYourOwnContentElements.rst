.. include:: /Includes.rst.txt
.. index::
   Content elements; custom
   pair: Create; Content elements
.. _adding-your-own-content-elements:

====================================
Create a custom content element type
====================================

This page explains how to create your own custom content element types. These
are comparable to the predefined content element types supplied by TYPO3. The latter
can be found in the system extension `fluid_styled_content`.

A content element can be based on fields already available in the `tt_content`
table.

It is also possible to add extra fields to the `tt_content`
table, see :ref:`ConfigureCE-Extend-tt_content`.

The data of the content element is then passed to a TypoScript object, in most
cases to a :ref:`t3tsref:cobj-fluidtemplate`.

Some data might need additional :ref:`ConfigureCE-DataProcessors`. Data
processors are frequently used for example to process files
(:ref:`t3tsref:FilesProcessor`) or to fetch related records
(:ref:`t3tsref:DatabaseQueryProcessor`).

A data processor can also be used to convert a string to an array,
as is done for example in the *table* content element with the field `bodytext`.

In these cases Fluid does not have to deal with these manipulations or transformation.

You can find the example below in the TYPO3 Documentation Team extension
:t3ext:`examples`.


Prerequisites
=============

The following examples require the system extension
:doc:`fluid_styled_content <typo3/cms-fluid-styled-content:Index>`.

It can be installed via Composer with:

.. code-block:: console

   composer req typo3/cms-fluid-styled-content


.. index:: Extension development; Custom content element
.. _AddingCE-use-an-extension:

Use an extension
================

We recommend to create your own extension for new custom content element types.
The following example uses the extension key `examples`.

Here you can find information on how to
:ref:`create an extension <extension-create-new>`.


.. index:: Content element; Registration
.. _RegisterCE:
.. _AddingCE-TCA-Overrides-tt_content:

Register the content element type
=================================

First we need to define the key of the new content element type. We use
`examples_newcontentelement` throughout the simple example.

Next the key needs to be added to the select field `CType`. This will make it
available in :guilabel:`Type` dropdown in the backend.

The following call needs to be added to the file
:file:`Configuration/TCA/Overrides/tt_content.php`.

..  literalinclude:: _AddingYourOwnContentElements/_tt_content.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

Now the new content element is available in the backend form. However it
currently contains no fields but the CType field.

.. include:: /Images/AutomaticScreenshots/CustomContentElements/CType.rst.txt


.. index:: Content element; Icon
.. _AddingCE-Icon:

About the icon
--------------

You can either use an existing `icon from the TYPO3 core
<https://typo3.github.io/TYPO3.Icons/icons/content.html>`__  or register your
own icon using the :ref:`Icon API <icon>`. In this example we use the icon
`content-text`, the same icon as the :guilabel:`Regular Text Element` uses.


.. index:: Content element; Wizard
.. _AddingCE-PageTSconfig:

Add it to the new content element wizard
========================================

Content elements in the :guilabel:`New Content Element Wizard` are easier
to find for editors. It is therefore advised to add the new content element
to this wizard (via page TSconfig).

..  literalinclude:: _AddingYourOwnContentElements/_page.tsconfig
    :language: typoscript
    :caption: EXT:my_extension/Configuration/page.tsconfig

.. versionchanged:: 12.0

   Starting with TYPO3 version 12.0 file :file:`EXT:examples/Configuration/page.tsconfig`
   is automatically included. For version 11.5 and below this file has to be included in the
   :file:`ext_localconf.php`. See :ref:`Setting global page TSconfig, compatible with TYPO3
   11 and 12 <t3tsref:page-tsconfig-v11-v12>`.

.. figure:: /Images/ManualScreenshots/Backend/ContentElementWizard.png
   :class: with-shadow
   :alt: Content element wizard with the new content element

   Content element wizard with the new content element


The content element wizard configuration is described in detail in
:ref:`content-element-wizard`.


.. index:: Content element; Backend form
.. _ConfigureCE-Fields:

Configure the backend form
==========================

Then you need to configure the backend fields for your new content element in
the file :file:`Configuration/TCA/Overrides/tt_content.php`:

..  literalinclude:: _AddingYourOwnContentElements/_tt_content_2.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

Now the backend form for the new content elements looks like this:

.. include:: /Images/AutomaticScreenshots/CustomContentElements/ContentElementFields.rst.txt


.. index:: Content element; Frontend rendering
.. _ConfigureCE-Frontend:

Configure the frontend rendering
================================

The output in the frontend gets configured in the setup TypoScript. See
:ref:`Add TypoScript to your extension <t3tsref:extdev-add-typoscript>` about how
to add TypoScript.

In the :file:`examples` extension the TypoScript can be found at
:file:`Configuration/TypoScript/setup.typoscript`

The Fluid templates for our custom content element will be saved in our
extension. Therefore we need to add the path to the
:ref:`t3tsref:cobj-fluidtemplate-properties-templaterootpaths`:

..  literalinclude:: _AddingYourOwnContentElements/_setup.typoscript
    :language: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

You can use any index (`200` in this example), just make sure it is unique.
If needed you can also add paths for partials and layouts.

Now you can register the rendering of your custom content element:

..  literalinclude:: _AddingYourOwnContentElements/_setup_2.typoscript
    :language: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

The :typoscript:`lib.contentElement` path is defined in file
:file:`EXT:fluid_styled_content/Configuration/TypoScript/Helper/ContentElement.typoscript`.
and uses a :ref:`t3tsref:cobj-fluidtemplate`.

We reference :doc:`fluid_styled_content <typo3/cms-fluid-styled-content:Index>`
:typoscript:`lib.contentElement` from our new content element and only change
the Fluid template to be used.

The Fluid template is configured by the
:ref:`t3tsref:cobj-fluidtemplate-properties-templatename` property as
`NewContentElement`.

This will load a :file:`NewContentElement.html` template file from the path
defined at the :typoscript:`templateRootPaths`.

In the example extension you can find the file at
:file:`EXT:examples/Resources/Private/Templates/NewContentElement.html`

`tt_content` fields can now be used in the Fluid template by accessing them via the `data` variable.
The following example shows the text entered in the richtext enabled field `bodytext`, using the html
saved by the richtext editor:

.. include:: /CodeSnippets/CustomContentElements/CustomContentElement.rst.txt

All fields of the table :php:`tt_content` are now available in the variable
`data`. Since we saved the content of `bodytext` in the richt text editor we
have to run it through `f:format.html` to resolve all links and other
formatting. Read more about :ref:`fluid`.

..  tip::

    During development you can output all available variables in a Fluid
    template by adding :html:`<f:debug>{_all}</f:debug>`.

    Even more convenient:
    :html:`<f:if condition="{condition}"><f:debug>{_all}</f:debug></f:if>`
    lets you easily turn debugging on or off, depending on whether you
    fill in "1" or "0" for *condition*.

    ..  code-block:: html
        :caption: Example lines

        <f:if condition="1"><f:debug>{settings}</f:debug></f:if>
        <f:if condition="0"><f:debug>{data}</f:debug></f:if>
        <f:if condition="1"><f:debug>{current}</f:debug></f:if>


Below you can see the example output of the new content element and a
dump of all available data:

.. figure:: /Images/ManualScreenshots/Frontend/ContentElements/NewContentElementOutput.png
   :class: with-border with-shadow
   :alt: The example output


.. _AddingCE-Extended-Example:

Extended example: Extend tt_content and use data processing
===========================================================

You can find the complete example in the  TYPO3 Documentation Team extension
:t3ext:`examples`. The steps for
creating a simple new content element as above need to be repeated. We use the
key *examples_newcontentcsv* in this example.

We want to output comma separated values (CSV) stored in the field bodytext.
As different programs use different separators to store CSV we want to make
the separator configurable.


.. index::
   pair: Content element; Extending tt_content
   Extension development; Extending tt_content
.. _ConfigureCE-Extend-tt_content:

Extending tt_content
--------------------

If the available fields in the table tt_content are not sufficient you can add
your own fields. In this case we need a field :php:`tx_examples_separator` from
which to choose the desired separator.

.. index::
   Files;EXT:{extkey}/ext_tables.sql
   Tables;tt_content
.. _ConfigureCE-Extend-tt_content-database:

Extending the database schema
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

First we extend the database schema by adding the following to the file
:file:`ext_tables.sql`:

..  literalinclude:: _AddingYourOwnContentElements/_ext_tables.sql
    :language: sql
    :caption: EXT:my_extension/ext_tables.sql

.. tip::

    Do a database compare in the :guilabel:`Admin Tools > Maintenance` module
    after changing the database schema (system maintainers only). Or call the
    console command:

    .. tabs::

       .. group-tab:: Composer-based installation

          .. code-block:: bash

             vendor/bin/typo3 extension:setup

       .. group-tab:: Classic mode installation (no Composer)

          .. code-block:: bash

             typo3/sysext/core/bin/typo3 extension:setup

.. index::
   pair: Content element; TCA
   Files; EXT:{extkey}/Configuration/TCA/Overrides/tt_content.php
.. _ConfigureCE-Extend-tt_content-tca:

Defining the field in the TCA
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The new field *tx_examples_separator* is added to the TCA definition of the table *tt_content* in the file
:file:`Configuration/TCA/Overrides/tt_content.php`:

..  literalinclude:: _AddingYourOwnContentElements/_tt_content_temporary_column.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

You can read more about defining fields via TCA in the :ref:`t3tca:start`.

Now the new field can be used in your Fluid template just like any other
tt_content field.

Another example shows the connection to a foreign table. This allows you to be
more flexible with the possible values in the select box. The new field
:sql:`myextension_reference` is a reference to another table of the extension
called :sql:`tx_myextension_mytable`:


..  literalinclude:: _AddingYourOwnContentElements/_tt_content_reference.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

Defining the field in the TCE
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

An individual modification of the newly added field :sql:`myextension_reference`
to the TCA definition of the table :sql:`tt_content` can be done in the
TYPO3 Core Engine (TCE) page TSconfig. In most cases it is necessary to set the page
id of the general storage folder. Then the examples extension will only use
the content records from the given page id.

..  literalinclude:: _AddingYourOwnContentElements/_page-page-id.tsconfig
    :language: typoscript
    :caption: EXT:my_extension/Configuration/page.tsconfig

If more than one page id is allowed, this configuration must be used instead
(and the above TCA must be modified to use the marker `###PAGE_TSCONFIG_IDLIST###`
instead of `###PAGE_TSCONFIG_ID###`):

..  literalinclude:: _AddingYourOwnContentElements/_page-page-id-list.tsconfig
    :language: typoscript
    :caption: EXT:my_extension/Configuration/page.tsconfig

..  note::

    As we are working with pure Fluid without Extbase here the new fields can
    be used right away. They need not be added to a model.


.. index:: pair: Content element; Data processing
.. _ConfigureCE-DataProcessors:

Data processing
---------------

Data processors can be used for data manipulation or fetching before the
variables get passed on to the template.

This is done in the
:ref:`dataProcessing <t3tsref:cobj-fluidtemplate-properties-dataprocessing>`
section where you can add an arbitrary number of data processors.

You can see a complete list of available
:ref:`data processors in the Typoscript Reference
<t3tsref:cobj-fluidtemplate-properties-dataprocessing>` or write a :ref:`custom
data processor <content-elements-custom-data-processor>`.

Each processor has to be added with a fully qualified class name and optional
parameters to be used in the data processor:

..  literalinclude:: _AddingYourOwnContentElements/_setup_myextension_newcontentcsv.typoscript
    :language: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

You can now iterate over the variable `myTable` in the Fluid template, in this
example :file:`Resources/Private/Templates/ContentElements/DataProcCsv.html`

.. include:: /CodeSnippets/CustomContentElements/DataProcCsv.rst.txt


The output would look like this (we added a debug of the variable `myTable`):

.. figure:: /Images/ManualScreenshots/Frontend/ContentElements/ContentElementWithDataProcessorOutput.png
   :class: with-shadow
   :alt: Output of the CommaSeparatedValueProcessor
