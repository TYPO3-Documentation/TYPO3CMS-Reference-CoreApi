.. include:: ../../../../../Includes.txt

.. _EntityAddedToPersistenceEvent:

=============================
EntityAddedToPersistenceEvent
=============================

Event which is fired after an object/entity was sent to persistence layer to be added,
but before updating the reference index and current session.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getObject()
   :sep:`|` :aspect:`ReturnType:` :php:`TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface`
   :sep:`|`

   |nbsp|

