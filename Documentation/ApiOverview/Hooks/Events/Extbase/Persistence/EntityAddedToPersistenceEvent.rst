.. include:: /Includes.rst.txt
.. index:: Events; EntityAddedToPersistenceEvent
.. _EntityAddedToPersistenceEvent:

=============================
EntityAddedToPersistenceEvent
=============================

Event which is fired after an object/entity was persisted on add.

The event is dispatched before updating the reference index, after adding the object to the persistence session.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getObject()
   :sep:`|` :aspect:`ReturnType:` :php:`TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface`
   :sep:`|`

   |nbsp|

