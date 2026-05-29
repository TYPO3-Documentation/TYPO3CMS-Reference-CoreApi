.. include:: /Includes.rst.txt
.. index:: FormEngine; Workflow
.. _FormEngine-Overview:

=======================
Main rendering workflow
=======================

The details of how to control or use only sub-parts of the rendering chain are
explained in more detail in the following sections.

Editing a record in the backend - usually in
:guilabel:`Content > Layout` or :guilabel:`Content > Records` modules - triggers the
:php-short:`\TYPO3\CMS\Backend\Controller\EditDocumentController` from routing
definitions in :php:`UriBuilder->buildUriFromRoute($moduleIdentifier)`
and hands over records from the tables which should be edited. This could be an
existing record, or it could be a command to create a form for a new record. The
:php-short:`\TYPO3\CMS\Backend\Controller\EditDocumentController` is the main
logic that is triggered when an editor switches between records.

The :php-short:`\TYPO3\CMS\Backend\Controller\EditDocumentController` has two
main jobs: triggering the rendering of records
via FormEngine; and handing over data from a FormEngine `POST` to the DataHandler
to persist in the database.

The rendering stage of the :php-short:`\TYPO3\CMS\Backend\Controller\EditDocumentController`
follows these steps:

*   Initialize main FormEngine data array with `POST` or `GET` data which specifies
    which record(s) should be be edited.

*   Select group of DataProviders.

*   Trigger FormEngine DataCompiler to enrich the data array with extra data by
    calling the selected DataProviders group.

*   Hand over DataCompiler result to an entry "render container" in FormEngine and receive back a result array.

*   Convert the raw result array into a :php-short:`\TYPO3\CMS\Backend\Form\FormResult`
    DTO using :php-short:`\TYPO3\CMS\Backend\Form\FormResultFactory`.

*   Use :php-short:`\TYPO3\CMS\Backend\Form\FormResultHandler` to pass
    assets such as CSS, JavaScript and labels to the
    :php-short:`TYPO3\CMS\Core\Page\PageRenderer`

*   The :php-short:`TYPO3\CMS\Core\Page\PageRenderer` outputs the compiled result.

..  uml:: /Images/Plantuml/FormEngine/FormEngineMainWorkflow.plantuml
    :align: center
    :width: 1000
    :caption: Main FormEngine workflow

The controller does two distinct things here. First, it initializes a data array which is enriched by
data providers from FormEngine that add all the information needed for the rendering stage. This data array
is then passed onto FormEngine rendering to produce a result array containing all the HTML, CSS and JavaScript.

..  deprecated:: 14.2
    The `outerWrapContainer` render type has been deprecated in favour of
    `formWrapContainer`. 
    The new container no longer renders the record
    heading or the record identity footer (icon, table title, uid) — that
    responsibility has moved to the controllers. If your controller relied on
    :php:`OuterWrapContainer` rendering those elements, you need to render them
    in your controller code after switching.
    See `Deprecation: #109192 - FormEngine OuterWrapContainer <https://docs.typo3.org/permalink/changelog:deprecation-109192-1741560000>`_.

In code, the basic workflow looks like this:

..  literalinclude:: _SomeClass.php
    :caption: EXT:my_extension/Classes/SomeClass.php

..  deprecated:: 14.2
    The class :php:`TYPO3\CMS\Backend\Form\FormResultCompiler` has been
    deprecated. See `Deprecation: #109230 - FormResultCompiler <https://docs.typo3.org/permalink/changelog:deprecation-109230-1773404000>`_.

Basically, behind the FormEngine concept is a 2-step process: first create an array to gather all
rendering-relevant information, then call the rendering engine using this array to produce output.

This 2-step process has a number of advantages:

*   The data compiler step can be modified by controller to only enrich the array
    with data relevant to the context. Data providers are encapulated into
    groups so that individual data providers can be omitted if not relevant in a given scope.

*   Data providing and rendering is split. Controllers can use the rendering
    stage of FormEngine even if all or parts of the data providers are omitted or
    their data comes from "elsewhere". Controllers can use the
    data provider stage of FormEngine and then output the result in an entirely different
    way than HTML, for example, for a TCA tree by an Ajax call which outputs a JSON array.

*   The functionality behind "data providing" and "rendering" can be modified to promote higher re-use and more
    flexibility, with only the "data array" as the main communication between them. This will become more obvious
    in the next sections which show that data providers are a linked list and rendering is a tree.
