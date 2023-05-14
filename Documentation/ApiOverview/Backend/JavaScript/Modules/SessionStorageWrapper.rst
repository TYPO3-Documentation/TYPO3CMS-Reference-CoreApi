.. include:: /Includes.rst.txt
.. index:: JavaScript (Backend); SessionStorage wrapper
.. _modules-sessionstorage:

======================
SessionStorage wrapper
======================

TYPO3 ships a module acting as a wrapper for :js:`sessionStorage`. It
behaves similar to the :js:`localStorage`, except that the stored data is dropped
after the browser session has ended.

The module :js:`TYPO3/CMS/Core/Storage/BrowserSession` allows
to store data in the :js:`sessionStorage`.

Example
=======

..  literalinclude:: _SessionStorageWrapper/_storage.js
    :language: js

API methods
===========

The module is called :js:`@typo3/backend/storage/abstract-client-storage`,
implemented by:

* :js:`@typo3/backend/storage/browser-session`
* :js:`@typo3/backend/storage/client`

:js:`get(key)`
    Fetches the data behind the key.

:js:`getByPrefix('common-prefix-')`
    Obtains multiple items prefixed by a given key either.

:js:`set(key, value)`
    Sets/overrides a key with any arbitrary content.

:js:`isset(key)` (bool)
    Checks if the key is in use.

:js:`unset(key)`
    Removes a key from the storage.

:js:`clear()`
    Empties all data inside the storage.

:js:`unsetByPrefix(prefix)`
    Empties all data inside the storage with their keys
    starting with a prefix.
