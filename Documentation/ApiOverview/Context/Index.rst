.. include:: ../../Includes.txt

.. _context-api:

=======================
Context API and Aspects
=======================

Introduction
============

Context API encapsulates various information for data retrieval (e.g. inside
the database) and analysis of current permissions and caching information.

Previously, various information was distributed inside globally accessible objects (:php:`$TSFE` or :php:`$GLOBALS['BE_USER']`)
like the current workspace ID or if a frontend or backend user is authenticated. Having a global object
available was also dependent on the current request type (frontend or backend), instead of having
one consistent place where all this data is located.

The context is set up at the very beginning of each TYPO3 entry point, keeping track
of the current time (formally known as :php:`$GLOBALS['EXEC_TIME']`, if a user is logged in,
and which workspace is currently accessed.

It can be retrieved anywhere via :php:`GeneralUtility::makeInstance()`:

.. code-block:: php

    $context = GeneralUtility::makeInstance(Context::class);

This information is separated in so-called "Aspects", each being responsible for a certain area:

.. _context_api_aspects_datetime:

DateTime Aspect
---------------

Contains time, date and timezone information for the current request.

In comparison to known behaviour until TYPO3 v9, :php:`DateTimeAspect`
replaces for example :php:`$GLOBALS['SIM_EXEC_TIME']` and :php:`$GLOBALS['EXEC_TIME']`.


.. _context_api_aspects_datetime_properties:

The DateTime Aspect accepts following properties:

=============  ============================================================  ======
Property       Call                                                          Result
=============  ============================================================  ======
``timestamp``  :php:`$context->getPropertyFromAspect('date', 'timestamp');`  unix timestamp as integer value
``timezone``   :php:`$context->getPropertyFromAspect('date', 'timezone');`   timezone name, e.g. `Germany/Berlin`
``iso``        :php:`$context->getPropertyFromAspect('date', 'iso');`        datetime as string in ISO 8601 format, e.g. `2004-02-12T15:19:21+00:00`
``full``       :php:`$context->getPropertyFromAspect('date', 'full');`       the complete DateTimeImmutable object
=============  ============================================================  ======

.. _context_api_aspects_datetime_example:

Example
~~~~~~~

.. code-block:: php

    $context = GeneralUtility::makeInstance(Context::class);

    // Reading the current data instead of $GLOBALS['EXEC_TIME']
    $currentTimestamp = $context->getPropertyFromAspect('date', 'timestamp');


.. _context_api_aspects_language:

Language Aspect
---------------

Contains information about language settings for the current request, including fallback and overlay logic.

In comparison to known behaviour until TYPO3 v9, :php:`LanguageAspect` replaces various properties related
to language Id, overlay and fallback logic, mostly within Frontend.


.. _context_api_aspects_language_properties:

The Language Aspect accepts following properties:

======================  =========================================================================  ======
Property                Call                                                                       Result
======================  =========================================================================  ======
``id``                  :php:`$context->getPropertyFromAspect('language', 'id');`                  the requested language of the current page as integer (uid)
``contentId``           :php:`$context->getPropertyFromAspect('language', 'contentId');`           the language id of records to be fetched in translation scenarios as integer (uid)
``fallbackChain``       :php:`$context->getPropertyFromAspect('language', 'fallbackChain');`       the fallback steps as array
``overlayType``         :php:`$context->getPropertyFromAspect('language', 'overlayType');`         one of :php:`LanguageAspect::OVERLAYS_OFF`, :php:`LanguageAspect::OVERLAYS_MIXED`, :php:`LanguageAspect::OVERLAYS_ON`, or :php:`LanguageAspect::OVERLAYS_ON_WITH_FLOATING` (default)
``legacyLanguageMode``  :php:`$context->getPropertyFromAspect('language', 'legacyLanguageMode');`  one of `strict`, `ignore` or `content_fallback`, kept for compatibility reasons. Don't use if not really necessary, the option will be removed rather sooner than later.
``legacyOverlayType``   :php:`$context->getPropertyFromAspect('language', 'legacyOverlayType');`   one of `hideNonTranslated`, `0` or `1`, kept for compatibility reasons. Don't use if not really necessary, the option will be removed rather sooner than later.
======================  =========================================================================  ======

**Overlay types:**

* :php:`LanguageAspect::OVERLAYS_OFF`:
    Just fetch records from the selected language as given by :php:`$GLOBALS['TSFE']->sys_language_content`. No overlay will happen, no fetching of the records from the default language. This boils down to "free mode" language handling.
    Records without a default language parent are included.
* :php:`LanguageAspect::OVERLAYS_MIXED`:
    Fetch records from the default language and overlay them with translations. If a record is not translated, the default language will be used.
* :php:`LanguageAspect::OVERLAYS_ON`:
    Fetch records from the default language and overlay them with translations. If a record is not translated, it will not be displayed.
* :php:`LanguageAspect::OVERLAYS_ON_WITH_FLOATING`:
    Fetch records from the default language and overlay them with translations. If a record is not translated, it will not be shown.
    Records without a default language parent are included.

**Replaced calls:**

* $TSFE->sys_language_uid -> id
* $TSFE->sys_language_content -> contentId
* $TSFE->sys_language_mode -> fallbackChain
* $TSFE->sys_language_mode -> legacyLanguageMode
* $TSFE->sys_language_contentOL -> legacyOverlayType

.. _context_api_aspects_language_example:

Example
~~~~~~~

.. code-block:: php

    $context = GeneralUtility::makeInstance(Context::class);

    // Reading the current fallback chain instead $TSFE->sys_language_mode
    $fallbackChain = $context->getPropertyFromAspect('language', 'fallbackChain');

.. _context_api_aspects_preview:

Preview Aspect
--------------

The `PreviewAspect` may be used to indicate that the frontend is in preview mode
(for example in case a workspace is previewed or hidden pages or records should be shown).

.. _context_api_aspects_preview_properties:


The Preview Aspect contains the following properties:

==============  ========================================================================  ======
Property        Call                                                                      Result
==============  ========================================================================  ======
``isPreview``   :php:`$context->getPropertyFromAspect('frontend.preview', 'isPreview');`  whether the frontend is currently in preview mode
==============  ========================================================================  ======

.. _context_api_aspects_typoscript:

TypoScript Aspect
-----------------

The `TypoScriptAspect` can be used to manipulate/check whether TemplateRendering is forced.

.. _context_api_aspects_typoscript_properties:


The Preview Aspect contains the following properties:

=========================  ==============================================================================  ======
Property                   Call                                                                            Result
=========================  ==============================================================================  ======
``forcedTemplateParsing``  :php:`$context->getPropertyFromAspect('typoscript', 'forcedTemplateParsing');`  whether TypoScript template parsing is forced
=========================  ==============================================================================  ======

.. _context_api_aspects_user:

User Aspect
-----------

Contains information about authenticated users in the current request. Can be used for frontend and backend users.

In comparison to known behaviour until TYPO3 v9, :php:`UserAspect` replaces various calls and checks on :php:`$GLOBALS['BE_USER']` and :php:`$GLOBALS['TSFE']->fe_user` options when only some information is needed.


.. _context_api_aspects_user_properties:

The User Aspect accepts following properties:

==============  ======================================================================  ======
Property        Call                                                                    Result
==============  ======================================================================  ======
``id``          :php:`$context->getPropertyFromAspect('backend.user', 'id');`           uid of the currently logged in user, 0 if no user
``username``    :php:`$context->getPropertyFromAspect('backend.user', 'username');`     the username of the currently authenticated user. Empty string if no user.
``isLoggedIn``  :php:`$context->getPropertyFromAspect('frontend.user', 'isLoggedIn');`  whether a user is logged in, as boolean.
``isAdmin``     :php:`$context->getPropertyFromAspect('backend.user', 'isAdmin');`      whether the user is admin, as boolean. Only useful for BEuser.
``groupIds``    :php:`$context->getPropertyFromAspect('backend.user', 'groupIds');`     the groups the user is a member of, as array
``groupNames``  :php:`$context->getPropertyFromAspect('frontend.user', 'groupNames');`  the names of all groups the user belongs to, as array
==============  ======================================================================  ======

.. _context_api_aspects_user_example:

Example
~~~~~~~

.. code-block:: php

    $context = GeneralUtility::makeInstance(Context::class);

    // Checking if a user is logged in
    $userIsLoggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');


.. _context_api_aspects_visibility:

Visibility Aspect
-----------------

The aspect contains whether to show hidden pages, records (content) or even deleted records.

In comparison to known behaviour until TYPO3 v9, :php:`VisibilityAspect` replaces for example :php:`$GLOBALS['TSFE']->showHiddenPages` and :php:`$GLOBALS['TSFE']->showHiddenRecords`.


.. _context_api_aspects_visibility_properties:

The Visibility Aspect accepts following properties:

=========================  ==============================================================================  ======
Property                   Call                                                                            Result
=========================  ==============================================================================  ======
``includeHiddenPages``     :php:`$context->getPropertyFromAspect('visibility', 'includeHiddenPages');`     whether hidden pages should be displayed, as boolean
``includeHiddenContent``   :php:`$context->getPropertyFromAspect('visibility', 'includeHiddenContent');`   whether hidden content should be displayed, as boolean
``includeDeletedRecords``  :php:`$context->getPropertyFromAspect('visibility', 'includeDeletedRecords');`  whether deleted records should be displayed, as boolean.
=========================  ==============================================================================  ======

.. _context_api_aspects_visibility_example:

Example
~~~~~~~

.. code-block:: php

    $context = GeneralUtility::makeInstance(Context::class);

    // Checking if hidden pages should be displayed
    $showHiddenPages = $context->getPropertyFromAspect('visibility', 'includeHiddenPages');


.. _context_api_aspects_workspace:

Workspace Aspect
----------------

The aspect contains information about the currently accessed workspace

In comparison to known behaviour until TYPO3 v9, :php:`WorkspaceAspect` replaces e.g. :php:`$GLOBALS['BE_USER']->workspace`.


.. _context_api_aspects_workspace_properties:

The Workspace Aspect accepts following properties:

=============  =================================================================  ======
Property       Call                                                               Result
=============  =================================================================  ======
``id``         :php:`$context->getPropertyFromAspect('workspace', 'id');`         UID of the currently accessed workspace as integer
``isLive``     :php:`$context->getPropertyFromAspect('workspace', 'isLive');`     whether the current workspace is live, or a custom offline WS, as boolean
``isOffline``  :php:`$context->getPropertyFromAspect('workspace', 'isOffline');`  whether the current workspace is offline, as boolean.
=============  =================================================================  ======

.. _context_api_aspects_workspace_example:

Example
~~~~~~~

.. code-block:: php

    $context = GeneralUtility::makeInstance(Context::class);

    // Retrieving the uid of currently accessed workspace
    $workspaceId = $context->getPropertyFromAspect('workspace', 'id');
