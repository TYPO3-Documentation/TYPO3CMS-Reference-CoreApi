:navigation-title: UriBuilder

..  include:: /Includes.rst.txt

..  _edit-links:

=====================================================
Use the backend UriBuilder to link to "Edit Records"
=====================================================

It is often needed to create links to edit records in the TYPO3 backend.
The same syntax is also used for creating new records.
TYPO3 provides an API for creating such links, namely
:code:`\TYPO3\CMS\Backend\Routing\UriBuilder`.

..  hint::

    Make sure to use :code:`\TYPO3\CMS\Backend\Routing\UriBuilder` to create
    backend links and not :code:`\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder`.

    The variable available as :code:`$this->uriBuilder` in a controller is the
    web routing UriBuilder and can only be used for frontend links.

When using Fluid templates the URI
either has to be created via PHP in the controller or a ViewHelper to be used.

..  _edit-links-basic:

Display a link to "Edit Record"
===============================

The :ref:`t3ViewHelper:typo3-backend-uri-editrecord` can be used to create a
"create new record" link:

..  literalinclude:: _UriBuilder/_EditRecord.html
    :caption: EXT:my_extension/Resources/Private/Partials/BackendModule/EditRecordLink.html

If you create the backend link via PHP it is possible to add more options like
default values for certain fields.

..  literalinclude:: _UriBuilder/_ModuleEditController.php
    :caption: EXT:my_extension/Classes/Controller.php
    :emphasize-lines: 20-30

..  _edit-links-examples:

Examples of "Edit record" links
===============================

The example extension :composer:`t3docs/examples` contains extended examples of
different types of edit/create record links in the backend.

Here an excerpt:

..  include:: _UriBuilder/_LinksAction.rst.txt

The links appear in the example backend module:

..  include:: /Images/AutomaticScreenshots/Examples/EditLinks/EditLinksDisplay.rst.txt

The examples above leads to the normal edit form for a page:

..  include:: /Images/AutomaticScreenshots/Examples/EditLinks/EditLinksEditFull.rst.txt


..  _edit-links-edit-restricted:

Additional options for editing records
======================================

When creating the link via PHP it is possible to add more options.

You can specify as many tables and UIDs as needed and you will get them all in
one single form!
(short way of editing more records from the same table at once).

Also the fields to be displayed can be restricted.

..  include:: _UriBuilder/_GetEditDoktypeLink.rst.txt

..  versionchanged:: 14.0

    Accepting  a comma-separated list of fields as value for `columnsOnly`
    has been removed. See :ref:`t3coreapi/13:edit-links-columnsOnly-migration`.

The fields to be included can be listed in the `columnsOnly` parameter, as a comma-separated list.
The order of the fields doesn't matter, they get displayed in the order they appear in the TCA.
If a field is missing or access restricted in one of the tables it just doesn't appear.
However if one record to be edited is missing none of the records gets displayed.

The example above results in the following:

..  include:: /Images/AutomaticScreenshots/Examples/EditLinks/EditLinksEditRestricted.rst.txt

..  _edit-links-new:

Display a link to "Create a New Record"
=======================================

The :ref:`t3ViewHelper:typo3-backend-uri-newrecord` can be used to create a
"create new record" link:

..  include:: _UriBuilder/_CreateHaikuBlankLink.rst.txt

If you create the backend link via PHP it is possible to add more options like
default values for certain fields.

..  include:: _UriBuilder/_CreateHaikuLinkPhp.rst.txt


..  versionchanged:: 14.0

    Accepting  a comma-separated list of fields as value for `columnsOnly`
    has been removed. See :ref:`t3coreapi/13:edit-links-columnsOnly-migration`.

It can then be displayed like this:

..  include:: _UriBuilder/_CreateHaikuLink.rst.txt

The link triggers the creation a new record for the table `tx_examples_haiku`
on page 1. It also sets a default value for the `title` field ("New haiku") and
selects the season "Spring". It only displays the fields defined by `columnsOnly`.

Note the following things:

*   the first parameter is called "edit" even if this is about creating a new record.
    The creation of a record is indicated by the value "new".
*   the key of the entry with value "new" indicates the pid on which the record is to be created.
*   the values get automatically url-encoded so you can use any special char in the defaults


This results in the following new record form with a pre-filled
title and season field.

..  include:: /Images/AutomaticScreenshots/Examples/EditLinks/EditLinksNew.rst.txt
