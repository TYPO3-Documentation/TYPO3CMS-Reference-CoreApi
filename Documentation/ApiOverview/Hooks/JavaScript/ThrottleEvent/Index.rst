.. include:: ../../../../Includes.txt


.. _Events_JavaScript_Throttle:

==============
Throttle Event
==============

A "throttled event" executes its handler after a configured waiting time over a time span. This event type is similar to
the debounced event, where the major difference is that a throttled event executes its listeners multiple times.

To construct the event listener, the module :js:`TYPO3/CMS/Core/Event/ThrottleEvent` must be imported. The constructor
accepts the following arguments:

* :js:`eventName` (string) - the event to listen on
* :js:`callback` (function) - the executed event listener when the event is triggered
* :js:`limit` (number) - the amount of milliseconds to wait until the event listener is executed again

.. hint::
   If an event spans over 2000ms and the wait time is configured to be 100ms,
   the event listener gets called up to 20 times in total (:math:`20=\frac{2000}{100}`).

.. code-block:: js

   new ThrottleEvent('mousewheel', function (e) {
     console.log('Executed every 50ms during the overall event time span');
   }, 50).bindTo(document.body);
