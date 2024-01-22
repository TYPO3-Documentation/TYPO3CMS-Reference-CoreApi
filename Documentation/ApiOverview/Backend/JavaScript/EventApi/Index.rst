..  include:: /Includes.rst.txt

..  _js-event-api:

=========
Event API
=========

The TYPO3 JavaScript Event API enables JavaScript developers to have a stable event listening
interface. The API takes care of common pitfalls like event delegation and clean
event unbinding.

.. warning::

    When using :js:`import` statements, it is vital that you use the suffix
    :file:`.js` to any import statements, when you are in the scope of `JavaScript/ES6`.
    Only when you create your code in `TypeScript` (using :file:`.ts` suffix), you
    need to omit the :file:`.js` extension in :js:`import` statements.
    See https://github.com/microsoft/TypeScript/issues/16577 for the reasoning of this.

Event Binding
=============

Each event strategy (see below) has two ways to bind a listener to an event:

Direct Binding
--------------

The event listener is bound to the element that triggers the event. This is done
by using the method :js:`bindTo()`, which accepts any element, :js:`document` and
:js:`window`.

Example:

..  literalinclude:: _DirectBinding.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/MyScript.js


Event Delegation
----------------

The event listener is called if the event was triggered to any matching element
inside its bound element.

Example:

..  literalinclude:: _EventDelegation.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/MyScript.js

The event listener is now called every time the element matching the selector
:js:`a[data-action="toggle"]` within :js:`document` is clicked.


Release an event
----------------

Since each event is an object instance, it is sufficient to call :js:`release()` to
detach the event listener.

Example:

..  literalinclude:: _ReleaseEvent.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/MyScript.js


Event strategies
================

The Event API brings several strategies to handle event listeners:

RegularEvent
------------

The :js:`RegularEvent` attaches a simple event listener to an event and element
and has no further tweaks. This is the common use case for event handling.

Arguments:

*   :js:`eventName` (string) - the event to listen on
*   :js:`callback` (function) - the event listener

Example:

..  literalinclude:: _RegularEvent.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/MyScript.js


DebounceEvent
-------------

The :js:`DebounceEvent` is most suitable if an event is triggered quite often
but executing the event listener is called only after a certain wait time.

Arguments:

*   :js:`eventName` (string) - the event to listen on
*   :js:`callback` (function) - the event listener
*   :js:`wait` (number) - the amount of milliseconds to wait before the event listener is called

..  versionchanged:: 13.0
    The parameter :js:`immediate` has been removed. There is no direct migration
    possible. An extension author may re-implement the removed behavior manually,
    or use the :ref:`ThrottleEvent <js-event-api-throttleevent>` module,
    providing a similar behavior.

Example:

..  literalinclude:: _DebounceEvent.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/MyScript.js


..  _js-event-api-throttleevent:

ThrottleEvent
-------------

Arguments:

*   :js:`eventName` (string) - the event to listen on
*   :js:`callback` (function) - the event listener
*   :js:`limit` (number) - the amount of milliseconds to wait before the event listener is called

The :js:`ThrottleEvent` is similar to the :js:`DebounceEvent`. The important
difference is that the event listener is called after the configured wait time
during the overall event time.

If an event time is about 2000ms and the wait time is configured to be 100ms,
the event listener gets called up to 20 times in total (2000 / 100).

Example:

..  literalinclude:: _ThrottleEvent.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/MyScript.js


RequestAnimationFrameEvent
--------------------------

The :js:`RequestAnimationFrameEvent` binds its execution to the browser's
:js:`RequestAnimationFrame` API. It is suitable for event listeners that
manipulate the DOM.

Arguments:

*   :js:`eventName` (string) - the event to listen on
*   :js:`callback` (function) - the event listener

Example:

..  literalinclude:: _RequestAnimationFrameEvent.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/MyScript.js
