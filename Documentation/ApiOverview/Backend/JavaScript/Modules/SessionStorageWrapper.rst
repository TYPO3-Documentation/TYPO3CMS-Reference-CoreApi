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

API methods
===========

`get(key)`
    Fetches the data behind the key.

`set(key, value)`
    Sets/overrides a key with any arbitrary content.

`isset(key)` (bool)
    Checks if the key is in use.

`unset(key)`
    Removes a key from the storage.

`clear()`
    Empties all data inside the storage.

`unsetByPrefix(prefix)`
    Empties all data inside the storage with their keys
    starting with a prefix
