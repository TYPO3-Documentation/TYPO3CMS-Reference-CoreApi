..  include:: /Includes.rst.txt
..  index:: Events; EnrichFileMetaDataEvent
..  _EnrichFileMetaDataEvent:

=========================
`EnrichFileMetaDataEvent`
=========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\EnrichFileMetaDataEvent`
is called after a record has been loaded from database. It allows other places
to extend the metadata at runtime.

The listeners receive the metadata record already resolved for the language
and the workspace of the current context. This applies to the frontend, the
backend, the command line, and eID requests.

..  versionchanged:: 15.0
    :changelog: important-110333-1785414572

    Before, the listener `typo3-frontend/overlay` resolved the record, and
    only in the frontend. An ordering of your listener against this
    identifier is ignored and can be dropped.

..  _enrich-file-meta-data-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _enrich-file-meta-data-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Resource\Event\EnrichFileMetaDataEvent
