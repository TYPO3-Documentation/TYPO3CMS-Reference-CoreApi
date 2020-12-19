.. include:: /Includes.rst.txt
.. index:: pair: Sessions; Users
.. _session-management:

=======================
User session management
=======================

User sessions in TYPO3 are represented as :php:`UserSession` objects. The :ref:`TYPO3
authentication service chain <authentication>` creates or updates user sessions
when authenticating users.

The :php:`UserSession` object contains all information regarding a users' session,
for website visitors with session data (e.g. basket for anonymous / not-logged-in users),
for frontend users as well as authenticated backend users. These are for example,
the session id, the session data, if a session was updated, if the session is anonymous,
or if it is marked as permanent and so on.

The :php:`UserSession` object can be used to change and
retrieve information in an object-oriented way.

For creating :php:`UserSession`-objects the :php:`UserSessionManager` must be used
since this manager acts as the main factory for user
sessions and therefore handles all necessary tasks like fetching, evaluating
and persisting them. Effectively encapsulating all calls to the
:php:`SessionManager` which is used for the :ref:`session backend <session-storage>`.


.. index:: UserSessionManager

Public API of :php:`UserSessionManager`
=======================================

The :php:`UserSessionManager` can be retrieved using it's static factory
method :php:`create()`::

   $loginType = 'BE'; // or 'FE' for frontend
   \TYPO3\CMS\Core\Session\UserSessionManager::create($loginType);

You can then use the :php:`UserSessionManager` to work
with user sessions. A couple of public methods are available:

+---------------------------------------------------------------+-----------------------------------------------------------------------+
| Method                                                        | Description                                                           |
+===============================================================+=======================================================================+
| createFromRequestOrAnonymous($request, $cookieName)           | Creates and returns a session from the given request. If the given    |
|                                                               | :php:`cookieName` can not be obtained from the request an anonymous   |
|                                                               | session will be returned.                                             |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| createFromGlobalCookieOrAnonymous($cookieName)                | Creates and returns a session from a global cookie (:php:`$_COOKIE`). |
|                                                               | If no cookie can be found for the given name, an anonymous session    |
|                                                               | will be returned.                                                     |
|                                                               | It is recommended to use the PSR-7-Request based method instead.      |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| createAnonymousSession()                                      | Creates and returns an anonymous session object (not persisted).      |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| createSessionFromStorage($sessionId)                          | Creates and returns a new session object for a given session id.      |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| hasExpired($session)                                          | Checks whether a given user session object has expired.               |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| willExpire($session, $gracePeriod)                            | Checks whether a given user session will expire within the given      |
|                                                               | grace period.                                                         |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| fixateAnonymousSession($session, $isPermanent)                | Persists an anonymous session without a user logged in, in order to   |
|                                                               | store session data between requests.                                  |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| elevateToFixatedUserSession($session, $userId, $isPermanent)  | Removes existing entries, creates and returns a new user session      |
|                                                               | object. See regenerateSession() below.                                |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| regenerateSession($sessionId, $sessionRecord, $anonymous)     | Regenerates the given session. This method should be used whenever a  |
|                                                               | user proceeds to a higher authorization level, e.g. when an           |
|                                                               | anonymous session is now authenticated.                               |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| updateSessionTimestamp($session)                              | Updates the session timestamp for the given user session if the       |
|                                                               | session is marked as "needs update" (which means the current          |
|                                                               | timestamp is greater than "last updated + a specified gracetime").    |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| isSessionPersisted($session)                                  | Checks whether a given session is already persisted.                  |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| removeSession($session)                                       | Removes a given session from the session backend.                     |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| updateSession($session)                                       | Updates the session data + timestamp in the session backend.          |
+---------------------------------------------------------------+-----------------------------------------------------------------------+
| collectGarbage($garbageCollectionProbability)                  | Calls the session backends :php:`collectGarbage()` method.           |
+---------------------------------------------------------------+-----------------------------------------------------------------------+

Public API of :php:`UserSession`
================================

The session object created or retrieved by the :php:`UserSessionManager` provides the following API methods:

+---------------------+-------------+------------------------------------------------------------------------------+
| Method              | Return type | Description                                                                  |
+=====================+=============+==============================================================================+
| getIdentifier()     | String      | Returns the session id. This is the :php:`ses_id` respectively the           |
|                     |             | :php:`AbstractUserAuthentication->id`.                                       |
+---------------------+-------------+------------------------------------------------------------------------------+
| getUserId()         | Int or NULL | Returns the user id the session belongs to. Can also reutrn `0` or NULL      |
|                     |             | Which indicates an anonymous session. This is the :php:`ses_userid`.         |
+---------------------+-------------+------------------------------------------------------------------------------+
| getLastUpdated()    | Int         | Returns the timestamp of the last session data update. This is the           |
|                     |             | :php:`ses_tstamp`.                                                           |
+---------------------+-------------+------------------------------------------------------------------------------+
| set($key, $value)   | Void        | Set or update session data value for a given key. It's also internally used  |
|                     |             | if calling :php:`AbstractUserAuthentication->setSessionData()`.              |
+---------------------+-------------+------------------------------------------------------------------------------+
| get($key)           | Mixed       | Returns the session data for the given key or NULL if the key does not       |
|                     |             | exist. It's internally used if calling                                       |
|                     |             | :php:`AbstractUserAuthentication->getSessionData()`.                         |
+---------------------+-------------+------------------------------------------------------------------------------+
| getData()           | Array       | Returns the whole data array.                                                |
+---------------------+-------------+------------------------------------------------------------------------------+
| hasData()           | Bool        | Checks whether the session has some data assigned.                           |
+---------------------+-------------+------------------------------------------------------------------------------+
| overrideData($data) | Void        | Overrides the whole data array. Can also be used to unset the array. This    |
|                     |             | also sets the :php:`$wasUpdated` pointer to :php:`TRUE`                      |
+---------------------+-------------+------------------------------------------------------------------------------+
| dataWasUpdated()    | Bool        | Checks whether the session data has been updated.                            |
+---------------------+-------------+------------------------------------------------------------------------------+
| isAnonymous()       | Bool        | Check if the user session is an anonymous one. This means, the session does  |
|                     |             | not belong to a logged-in user.                                              |
+---------------------+-------------+------------------------------------------------------------------------------+
| getIpLock()         | string      | Returns the ipLock state of the session                                      |
+---------------------+-------------+------------------------------------------------------------------------------+
| isNew()             | Bool        | Checks whether the session is new.                                           |
+---------------------+-------------+------------------------------------------------------------------------------+
| isPermanent()       | Bool        | Checks whether the session was marked as permanent on creation.              |
+---------------------+-------------+------------------------------------------------------------------------------+
| needsUpdate()       | Bool        | Checks whether the session has to be updated.                                |
+---------------------+-------------+------------------------------------------------------------------------------+
| toArray()           | Array       | Returns the session and its data as array in the old `sessionRecord` format. |
+---------------------+-------------+------------------------------------------------------------------------------+
