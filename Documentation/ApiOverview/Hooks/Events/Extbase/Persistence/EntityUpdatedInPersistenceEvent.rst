.. include:: ../../../../../Includes.txt

.. _EntityUpdatedInPersistenceEvent:

===============================
EntityUpdatedInPersistenceEvent
===============================

Event which is fired after an object/entity was sent to persistence layer to be updated.

API
===

 - :Method:
         getObject()
   :Description:
         Returns the entity that was sent to the persistence layer to be updated.
   :ReturnType:
         :php:`TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface`
