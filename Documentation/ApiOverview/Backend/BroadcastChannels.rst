.. include:: /Includes.rst.txt
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

Any backend module may send a message using the
:js:`@typo3/backend/broadcast-service.js` :ref:`ES6 module <backend-javascript-es6>`.

The payload of such a message is an object that consists at least of the
following properties:

* :js:`componentName` - the name of the component that sends the message (e.g. extension name)
* :js:`eventName` - the event name used to identify the message

A message may contain any other property as necessary. The final event
name to listen is a composition of "typo3", the component name and the
event name, e.g. `typo3:my_extension:my_event`.

To send a message, the :js:`post()` method must be used.

Example code:

..  literalinclude:: _BroadcastChannels/_my-broadcast-service.js
    :caption: EXT:my_broadcast_extension/Resources/Public/JavaScript/my-broadcast-service.js

.. index::
   Broadcast service; Receiving
   Hook; typo3/backend.php->constructPostProcess

Receive a message
-----------------

To receive and thus react on a message, an event handler needs to be registered that listens to the composed event
name (e.g. `typo3:my_component:my_event`) sent to :js:`document`.

The event itself contains a property called `detail` **excluding** the component name and event name.

Example code:

..  literalinclude:: _BroadcastChannels/_my-event-handler.js
    :caption: EXT:my_extension/Resources/Public/JavaScript/my-event-handler.js

..  seealso::
    *   :ref:`Loading ES6 JavaScript <backend-javascript-es6-loading>`
    *   :ref:`Migration from RequireJS to ES6 <t3coreapi-12:requirejs-migration>`

Hook into
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess']`
to load a custom :php:`\TYPO3\CMS\Backend\Controller\BackendController` hook
that loads the event handler's JavaScript.

Example code:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'][]
        = \MyVendor\MyExtension\Hooks\BackendControllerHook::class . '->registerClientSideEventHandler';

..  literalinclude:: _BroadcastChannels/_BackendControllerHook.php
    :caption: EXT:my_extension/Classes/Hooks/BackendControllerHook.php

..  versionadded:: 14.1
    The new method  :php:`PageRenderer->addInlineLanguageDomain()`
    (class :php:`TYPO3\CMS\Core\Page\PageRenderer`)
    is used to load labels from a language domain and make them available in
    JavaScript through the :javascript:`TYPO3.lang` object. The older method
    :php:`PageRenderer->addInlineLanguageLabelFile()` is
    still valid for legacy, file-based labels.

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    services:
      _defaults:
        autowire: true
        autoconfigure: true
        public: false

      MyVendor\MyExtension\Hooks\BackendControllerHook:
        public: true

See also: :ref:`knowing-what-to-make-public`
