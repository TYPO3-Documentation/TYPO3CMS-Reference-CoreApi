.. include:: ../../../Includes.txt


.. _Events_JavaScript:

====================
JavaScript Event API
====================

The Event API in TYPO3 incorporates different techniques to handle JavaScript events in an easy, convenient and
performant manner. Event listeners may be bound directly to an element or to multiple elements using event delegation.

TYPO3 ships different event strategies, implementing the same interface which makes all strategies API-wise
interchangeable.


Bind to an element
------------------

To bind an event listener to an element directly, the API method :js:`bindTo()` must be used. The method takes one
argument that describes the element to which the event listener is bound. Accepted is any :js:`Node` element,
:js:`document` or :js:`window`.

Example:

.. code-block:: js

   // AnyEventStrategy is a placeholder, concrete implementations are handled in the following chapters
   new AnyEventStrategy('click', callbackFn).bindTo(document.getElementById('foobar'));

.. important::
   Event delegation needs a bubbling event which not the default case for :js:`CustomEvent()`. Define the option in
   the event initialization as follows: :js:`new CustomEvent('my-event', {bubbles: true});`.


Bind to multiple elements
-------------------------

To bind an event listener to multiple elements, the so-called "event delegation" may be used. An event listener is
attached to a super element (e.g. a table) but reacts on events triggered by child elements within that super element.

This approach reduces the overhead in the browser as no listener must be installed for each element.

To make use of this approach the method :js:`delegateTo()` must be used which accepts two arguments:

* :js:`element` - any :js:`Node` element, :js:`document` or :js:`window`
* :js:`selector` - the selector to match any element that triggers the event listener execution

In the following example all elements matching `.any-class` within `#foobar` execute the event listener when clicked:

.. code-block:: js

   // AnyEventStrategy is a placeholder, concrete implementations are handled in the following chapters
   new AnyEventStrategy('click', callbackFn).delegateTo(document.getElementById('foobar'), '.any-class');

To access the element that triggered the event, :js:`this` may be used.


Release an event
----------------

If an event listener is not required anymore, it may be removed from the element it's attached. To release a registered
event, the method :js:`release()` must be used. This method takes no arguments.

Example:

.. code-block:: js

   // AnyEventStrategy is a placeholder, concrete implementations are handled in the following chapters
   const event = new AnyEventStrategy('click', callbackFn);
   event.delegateTo(document.getElementById('foobar'), '.any-class');

   // Release the event
   event.release();


**Contents:**

.. toctree::
   :titlesonly:
   :maxdepth: 1

   RegularEvent/Index
   DebounceEvent/Index
   ThrottleEvent/Index
   RequestAnimationFrameEvent/Index
