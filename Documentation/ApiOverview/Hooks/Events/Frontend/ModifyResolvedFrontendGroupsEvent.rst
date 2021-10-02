.. include:: /Includes.rst.txt
.. index:: Events; ModifyHrefLangTagsEvent
.. _ModifyHrefLangTagsEvent:

=======================
ModifyHrefLangTagsEvent
=======================

.. versionadded:: 11.5

Event:
   :php:`TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent`

Description:
   Event listener to allow to add custom Frontend Groups to a (frontend)
   request regardless if a user is logged in or not.

Prior to TYPO3 v11.0, the :php:`getGroupsFE` authentication service allowed
to add and manipulate Frontend User Groups to be attached to a
FrontendUserAuthentication request during runtime. This functionality was
removed during the refactoring of the authentication services. This event allows
to achieve the same functionality.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getRequest()
   :sep:`|` :aspect:`ReturnType:` \Psr\Http\Message\ServerRequestInterface
   :sep:`|`

   |nbsp|

getUser()
   :sep:`|` :aspect:`ReturnType:` FrontendUserAuthentication
   :sep:`|`

   |nbsp|

getGroups()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setGroups()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|` :aspect:`Arguments:` `groups` The groups to be set
   :sep:`|`

   |nbsp|

