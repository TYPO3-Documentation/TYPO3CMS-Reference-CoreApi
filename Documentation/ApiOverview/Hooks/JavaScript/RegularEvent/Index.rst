.. include:: /Includes.rst.txt


.. _Events_JavaScript_Regular:

=============
Regular Event
=============

A "regular event" is a very simple mechanism to bind an event listener to an element. The event listener is executed
every time the event is triggered.

To construct the event listener, the module :js:`TYPO3/CMS/Core/Event/RegularEvent` must be imported. The constructor
accepts the following arguments:

* :js:`eventName` (string) - the event to listen on
* :js:`callback` (function) - the executed event listener when the event is triggered

.. code-block:: js

   new RegularEvent('click', function (e) {
     console.log('Clicked element:', e.target);
   }).bindTo(document.getElementById('#'));
