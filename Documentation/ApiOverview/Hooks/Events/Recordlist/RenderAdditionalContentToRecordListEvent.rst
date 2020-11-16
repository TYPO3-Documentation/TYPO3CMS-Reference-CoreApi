.. include:: /Includes.rst.txt


.. _RenderAdditionalContentToRecordListEvent:


========================================
RenderAdditionalContentToRecordListEvent
========================================

.. versionadded:: 11.0

Event to add content before or after the main content of the list module.


API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getRequest()
   :sep:`|` :aspect:`ReturnType:` Psr\\Http\\Message\\ServerRequestInterface
   :sep:`|`

   Returns the request object from the list module request.

addContentAbove(string $contentAbove)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Add additional content as string as it is to be shown above the main content.

addContentBelow(string $contentBelow)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Add additional content as string as it is to be shown below the main content.
