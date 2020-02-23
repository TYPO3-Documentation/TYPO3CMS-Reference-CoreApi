.. include:: ../../../../../Includes.txt

.. _AfterObjectThawedEvent:

======================
AfterObjectThawedEvent
======================

:php:`TYPO3\CMS\Extbase\Event\Persistence\AfterObjectThawedEvent`

Allows to modify values when creating domain objects.

API
===

 - :Method:
         getObject()
   :Description:
         Returns the domain object that was passed in the constructor.
   :ReturnType:
         TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface


 - :Method:
         getRecord()
   :Description:
         Return the record that was passed in the constructor.
   :ReturnType:
          array


