..  include:: /Includes.rst.txt
..  index:: Events; RecordCreationEvent
..  _RecordCreationEvent:

===================
RecordCreationEvent
===================

..  versionadded:: 13.3
    The PSR-14 :php-short:`\TYPO3\CMS\Core\Domain\Event\RecordCreationEvent` is introduced in
    order to allow the manipulation of any property
    before being used to create a
    `Database Record <https://docs.typo3.org/permalink/t3coreapi:database-records>`_ object.

The `Database Record <https://docs.typo3.org/permalink/t3coreapi:database-records>`_ object, which
represents a raw database record based on TCA and is usually used in the
frontend (via Fluid Templates).

The properties of those Record
objects are transformed / expanded from their raw database value into
"rich-flavored" values. Those values might be relations to Record objects implementing
:php-short:`\TYPO3\CMS\Core\Domain\RecordInterface`,
:php-short:`\TYPO3\CMS\Extbase\Domain\Model\FileReference`,
:php:`\TYPO3\CMS\Core\Resource\Folder` or :php:`\DateTimeImmutable` objects.

TYPO3 does not know about custom field meanings, for example latitude and
longitude information, stored in an input field or user settings stored as
JSON in a TCA type `json <https://docs.typo3.org/permalink/t3tca:columns-json>`_
field.

This event is dispatched right before a Record object is created and
therefore allows to fully manipulate any property, even the ones already
transformed by TYPO3.

The new event is stoppable (implementing :php-short:`\Psr\EventDispatcher\StoppableEventInterface`), which
allows listeners to actually create a Record object, implementing
:php:`\TYPO3\CMS\Core\Domain\RecordInterface` completely on their
own.

..  _RecordCreationEvent-example:

Example
=======

The event listener class, using the PHP attribute :php:`#[AsEventListener]` for
registration, creates a :php:`Coordinates` object based on the field value of
the :php:`coordinates` field for the custom :php:`maps` content type.

..  literalinclude:: _RecordCreationEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Domain/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

The model could for example look like this:

..  literalinclude:: _RecordCreationEvent/_Coordinates.php
    :caption: EXT:my_extension/Classes/Domain/Model/Coordinates.php

..  _RecordCreationEvent-api:

API
===

..  include:: /CodeSnippets/Events/Core/RecordCreationEvent.rst.txt

..  important::

    The event operates on the :php-short:`\TYPO3\CMS\Core\Domain\RecordInterface`
    instead of an actual implementation. This way, extension authors are able
    to set custom records, implementing the interface.
