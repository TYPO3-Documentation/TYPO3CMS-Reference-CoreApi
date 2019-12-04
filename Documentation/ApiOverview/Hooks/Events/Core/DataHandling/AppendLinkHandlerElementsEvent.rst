.. include:: ../../../../../Includes.txt


.. _AppendLinkHandlerElementsEvent:


==============================
AppendLinkHandlerElementsEvent
==============================

Event fired so listeners can intercept add elements when checking 
links within the SoftRef parser.

API
---


 - :Method:
         getLinkParts()
   :Description:
         Returns the different parts of the current link.
   :ReturnType:
         array


 - :Method:
         getContent()
   :Description:
         Returns the content of the link.
   :ReturnType:
         string


 - :Method:
         getElements()
   :Description:
         Returns elements of link.
   :ReturnType:
         array


 - :Method:
         getIdx()
   :Description:
         Gets index of current element.
   :ReturnType:
         int


 - :Method:
         getTokenId()
   :Description:
         Gets current token ID.
   :ReturnType:
         string


 - :Method:
         setLinkParts(array $linkParts)
   :Description:
         Overwrites / sets current link parts.
   :ReturnType:
         void


 - :Method:
         setContent(string $content)
   :Description:
         Overwrites / sets the link content.
   :ReturnType:
         void


 - :Method:
         setElements(array $elements)
   :Description:
         Overwrites / sets the elements.
   :ReturnType:
         void


 - :Method:
         addElements(array $elements)
   :Description:
         Appends elements (with `array_replace_recursive`) - 
         existing elements with the same key will be overwritten.
         Sets `isResolved` to true (see below).
   :ReturnType:
         void


 - :Method:
         isResolved()
   :Description:
         Whether the link has been resolved already.
   :ReturnType:
         bool

