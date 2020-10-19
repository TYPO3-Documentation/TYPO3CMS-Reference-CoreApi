.. include:: ../../../../../Includes.txt

.. _EntityRemovedFromPersistenceEvent:

=================================
EntityRemovedFromPersistenceEvent
=================================

Event which is fired after an object/entity was sent to persistence layer to be removed.

API
===

 - :Method:
         getObject()
   :Description:
         Returns the entity that was sent to the persistence layer to be removed.
   :ReturnType:
         :php:`TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface`
