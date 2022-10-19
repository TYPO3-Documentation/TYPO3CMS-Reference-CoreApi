.. include:: /Includes.rst.txt
.. highlight:: javascript
.. index:: ! Broadcast service
.. _broadcast_channels:

==================
Broadcast channels
==================

It is possible to send broadcast messages from anywhere in TYPO3 that are
listened to via JavaScript.

.. warning::

   This API is considered internal and may change anytime until declared being stable.

.. index:: Broadcast service; Sending

Send a message
--------------

..  versionchanged:: 12.0
    The RequireJS module :js:`TYPO3/CMS/Backend/BroadcastService` has been migrated
    to the ES6 module :js:`@typo3/backend/broadcast-service.js`.
    See also :ref:`backend-javascript-es6`.

Any backend module may send a message using the
:js:`@typo3/backend/broadcast-service.js` :ref:`ES6 module <backend-javascript-es6>`.

The payload of such a message is an object that consists at least of the
following properties:

* :js:`componentName` - the name of the component that sends the message (e.g. extension name)
* :js:`eventName` - the event name used to identify the message

A message may contain any other property as necessary. The final event name to listen is a composition of "typo3", the
component name and the event name, e.g. `typo3:my_extension:my_event`.

.. attention::

    Since a polyfill is in place to add support for Microsoft Edge, the
    payload must contain JSON-serializable content only.

To send a message, the :js:`post()` method must be used.

Example code:

..  code-block:: js
    :caption: EXT:my_broadcast_extension/Resources/Public/JavaScript/my-broadcast-service.js

    import BroadcastService from "@typo3/backend/broadcast-service.js";

    class MyBroadcastService {
	    constructor() {
            const payload = {
                componentName: 'my_extension',
                eventName: 'my_event',
                hello: 'world',
                foo: ['bar', 'baz']
            };
            BroadcastService.post(payload);
        }
    }
    export default new MyBroadcastService();

.. index::
   Broadcast service; Receiving
   Hook; typo3/backend.php->constructPostProcess

Receive a message
-----------------

To receive and thus react on a message, an event handler needs to be registered that listens to the composed event
name (e.g. `typo3:my_component:my_event`) sent to :js:`document`.

The event itself contains a property called `detail` **excluding** the component name and event name.

Example code:

..  code-block:: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/my-event-handler.js

    class MyEventHandler {
	    constructor() {
            document.addEventListener('typo3:my_component:my_event', (e) => eventHandler(e.detail));
        }

        function eventHandler(detail) {
            console.log(detail); // contains 'hello' and 'foo' as sent in the payload
        }
    }
    export default new MyEventHandler();

..  seealso::
    *   :ref:`Loading ES6 JavaScript <backend-javascript-es6-loading>`
    *   :ref:`Migration from RequireJS to ES6 <requirejs-migration>`

Hook into
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess']`
to load a custom :php:`BackendController` hook that loads the event handler's
JavaScript.

Example code:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'][]
        = \MyVendor\MyExtension\Hooks\BackendControllerHook::class . '->registerClientSideEventHandler';


.. code-block:: php
    :caption: EXT:my_extension/Classes/Hooks/BackendControllerHook.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Page\PageRenderer;

    final class BackendControllerHook
    {
        public function registerClientSideEventHandler(): void
        {
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->loadJavaScriptModule('@myvendor/my-extension/event-handler.js');
            $pageRenderer->addInlineLanguageLabelFile('EXT:my_extension/Resources/Private/Language/locallang_slug_service.xlf');
        }
    }


