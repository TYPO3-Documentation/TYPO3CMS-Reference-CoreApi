.. include:: /Includes.rst.txt
.. index:: pair: Session; User
.. _session-management:

=======================
User session management
=======================

User sessions in TYPO3 are represented as :php:`UserSession` objects. The :ref:`TYPO3
authentication service chain <authentication>` creates or updates user sessions
when authenticating users.

The :php:`UserSession` object contains all information regarding a user's session,
for website visitors with session data (e.g. basket for anonymous / not-logged-in users),
for frontend users as well as authenticated backend users. These are for example,
the session id, the session data, if a session was updated, if the session is anonymous,
or if it is marked as permanent and so on.

The :php:`UserSession` object can be used to change and
retrieve information in an object-oriented way.

For creating :php:`UserSession` objects the :php:`UserSessionManager` must be used
since this manager acts as the main factory for user
sessions and therefore handles all necessary tasks like fetching, evaluating
and persisting them. It effectively encapsulates all calls to the
:php:`SessionManager` which is used for the
:ref:`session backend <session-storage>`.


.. index:: UserSessionManager

Public API of :php:`UserSessionManager`
=======================================

The :php:`UserSessionManager` can be retrieved using its static factory
method :php:`create()`:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Session\UserSessionManager;

   $loginType = 'BE'; // or 'FE' for frontend
   $userSessionManager = UserSessionManager::create($loginType);

You can then use the :php:`UserSessionManager` to work
with user sessions. A couple of public methods are available:

..  include:: _UserSessionManager.rst.txt

Public API of :php:`UserSession`
================================

The session object created or retrieved by the :php:`UserSessionManager`
provides the following API methods:

..  include:: _UserSession.rst.txt
