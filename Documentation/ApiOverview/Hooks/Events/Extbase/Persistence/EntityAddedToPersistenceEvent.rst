.. include:: ../../../../../Includes.txt

.. _EntityAddedToPersistenceEvent:

=============================
EntityAddedToPersistenceEvent
=============================

Event which is fired after an object/entity was sent to persistence layer to be added,
but before updating the reference index and current session.

API
===

 - :Method:
         getObject()
   :Description:
         Returns the entity that was sent to the persistence layer to be added.
   :ReturnType:
         :php:`TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface`
