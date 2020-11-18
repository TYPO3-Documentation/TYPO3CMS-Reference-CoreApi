.. include:: /Includes.rst.txt


.. _RenderAdditionalContentToRecordListEvent:


========================================
RenderAdditionalContentToRecordListEvent
========================================

.. versionadded:: 11.0

Event to add content before or after the main content of the list module.


API
---

.. rst-class:: dl-parameters

getRequest()
   :sep:`|` :aspect:`ReturnType:` Psr\\Http\\Message\\ServerRequestInterface
   :sep:`|`

   Returns the request object from the list module request.

addContentAbove(string $contentAbove)
   :sep:`|` :aspect:`Arguments:` `$contentAbove` string with HTML Content
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Add additional content as string as it is to be shown above the main content.

addContentBelow(string $contentBelow)
   :sep:`|` :aspect:`Arguments:` `$contentBelow` string with HTML Content
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Add additional content as string as it is to be shown below the main content.

getAdditionalContentAbove()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   Returns previously set additional content as string.

getAdditionalContentBelow()
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Returns previously set additional content as string.
