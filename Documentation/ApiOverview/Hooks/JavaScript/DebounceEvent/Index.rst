.. include:: /Includes.rst.txt


.. _Events_JavaScript_Debounce:

==============
Debounce Event
==============

A "debounced event" executes its handler only once in a series of the same events. If the event listener is configured
to execute immediately, it's executed right after the first event is fired until a period of time passed since the last
event. If its not configured to execute immediately, which is the default setting, the event listener is executed after
the period of time passed since the last event fired.

This type of event listening is suitable when a series of the same event is fired, e.g. the `mousewheel` or `resize`
events.

To construct the event listener, the module :js:`TYPO3/CMS/Core/Event/DebounceEvent` must be imported. The constructor
accepts the following arguments:

* :js:`eventName` (string) - the event to listen on
* :js:`callback` (function) - the executed event listener when the event is triggered
* :js:`wait` (number) - the amount of milliseconds to wait the event listener is either executed or locked
* :js:`immediate` (boolean) - defined whether the event listener is executed before or after the waiting time

.. code-block:: js

   new DebounceEvent('mousewheel', function (e) {
     console.log('Executed 200ms after the last mousewheel event was fired');
   }, 200).bindTo(document.body);

   new DebounceEvent('mousewheel', function (e) {
     console.log('Executed right after the first 200ms after the last mousewheel event was fired');
   }, 200, true).bindTo(document.body);
