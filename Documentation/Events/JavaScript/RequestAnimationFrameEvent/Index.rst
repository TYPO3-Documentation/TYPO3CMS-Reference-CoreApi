.. include:: /Includes.rst.txt


.. _Events_JavaScript_rAF:

===========================
RequestAnimationFrame Event
===========================

A "request animation frame event" is similar to using :js:`ThrottleEvent` with a limit of `16`, as this event type
incorporates the browser's RequestAnimationFrame API (rAF) which aims to run at 60 fps (:math:`16 = \frac{1}{60}`) but
decides internally the best timing to schedule the rendering.

The best suited use-case for this event type is on "paint jobs", e.g. calculating the size of an element or move
elements around.

.. important::
   Due to the behavior of rAF, any event listener is not executed if the browser's tab is not active.

To construct the event listener, the module :js:`TYPO3/CMS/Core/Event/RequestAnimationFrameEvent` must be imported.
The constructor accepts the following arguments:

* :js:`eventName` (string) - the event to listen on
* :js:`callback` (function) - the executed event listener when the event is triggered

.. code-block:: js

   const el = document.querySelector('.item');
   new RequestAnimationFrameEvent('scroll', function () {
     el.target.style.width = window.scrollY + 100 + 'px';
   }).bindTo(window);
