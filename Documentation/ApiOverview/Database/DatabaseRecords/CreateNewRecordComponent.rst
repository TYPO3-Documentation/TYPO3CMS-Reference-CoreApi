:navigation-title: New record component

..  include:: /Includes.rst.txt
..  _news-record-component:

=====================================================
New record component in the Contents > Records module
=====================================================

..  versionadded:: 14.0
    Record types are now also displayed in the "New record" component.

    See `Feature: #99459 - Respect record type while creating new records <https://docs.typo3.org/permalink/changelog:feature-99459-1672857664>`_.

..  figure:: /Images/ManualScreenshots/Backend/NewRecordComponent.png
    :alt: TYPO3 Backend with the "New Record" component in the Contents > Records module

    The "New Record" component in the :guilabel:`Contents > Records` module

The "Create new record" component in the backend, which is accessible in
the :guilabel:`Contents > Records` module can be used by editors and admins
to create records in the TYPO3 backend.

Tables defined in the `Table configuration array (TCA) <https://docs.typo3.org/permalink/t3tca:start>`_
are automatically detected and displayed in the component if they are allowed on
the current page.

All available record types for tables that support sub-schemas
(record types) are also displayed.

Record types can be prevented from being displayed in the "New record" component
by setting `$GLOBALS['TCA']['my_table']['types']['my_type']['creationOptions']['enableDirectRecordTypeCreation'] = false`
in TCA.

Additionally, the PSR-14 `ModifyNewRecordCreationLinksEvent <https://docs.typo3.org/permalink/t3coreapi:modifynewrecordcreationlinksevent>`_
allows for complete customization of the creation links.
