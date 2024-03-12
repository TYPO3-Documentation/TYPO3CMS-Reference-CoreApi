..  include:: /Includes.rst.txt

..  _context-api:

=======================
Context API and aspects
=======================

Introduction
============

The Context API encapsulates various information for data retrieval (for
example, inside the database) and analysis of current permissions and caching
information.

Previously, various information was distributed inside globally accessible
objects (:php:`$TSFE` or :php:`$GLOBALS['BE_USER']`) like the current workspace
ID or if a frontend or backend user is authenticated. Having a global object
available was also dependent on the current request type (frontend or backend),
instead of having one consistent place where all this data is located.

The context is set up at the very beginning of each TYPO3 entry point, keeping
track of the current time (formally known as :php:`$GLOBALS['EXEC_TIME']`),
if a user is logged in (formerly known as :php:`$GLOBALS['TSFE']->loginUser`),
and which workspace is currently accessed.

The :php:`\TYPO3\CMS\Core\Context\Context` object can be retrieved via
:ref:`dependency injection <DependencyInjection>`:

..  literalinclude:: _MyController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

This information is separated in so-called
":ref:`aspects <context_api_aspects>`", each being responsible for a certain
area.


..  _context_api_aspects:

Aspects
=======

..  contents::
    :depth: 1
    :local:

..  _context_api_aspects_datetime:

Date time aspect
----------------

Contains time, date and timezone information for the current request.

..  _context_api_aspects_datetime_properties:

The date time aspect, :php:`\TYPO3\CMS\Core\Context\DateTimeAspect`, accepts
the following properties:

..  confval:: timestamp

    :Call: :php:`$this->context->getPropertyFromAspect('date', 'timestamp');`

    Returns the Unix timestamp as an integer value.

..  confval:: timezone

    :Call: :php:`$this->context->getPropertyFromAspect('date', 'timezone');`

    Returns the timezone name, for example, "Germany/Berlin".

..  confval:: iso

    :Call: :php:`$this->context->getPropertyFromAspect('date', 'iso');`

    Returns the datetime as string in
    `ISO 8601 <https://en.wikipedia.org/wiki/ISO_8601>`__ format, for example,
    "2004-02-12T15:19:21+00:00".

..  confval:: full

    :Call: :php:`$this->context->getPropertyFromAspect('date', 'full');`

    Returns the complete
    `\DateTimeImmutable <https://www.php.net/manual/class.datetimeimmutable.php>`__
    object.


..  _context_api_aspects_datetime_example:

Example
~~~~~~~

..  literalinclude:: _MyControllerUsingDateAspect.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php


..  _context_api_aspects_language:

Language aspect
---------------

Contains information about language settings for the current
:ref:`request <typo3-request>`, including fallback and overlay logic.

..  _context_api_aspects_language_properties:

The language aspect, :php:`\TYPO3\CMS\Core\Context\LanguageAspect` accepts the
following properties:

..  confval:: id

    :Call: :php:`$this->context->getPropertyFromAspect('language', 'id');`

    Returns the requested language of the current page as integer (uid).

..  confval:: contentId

    :Call: :php:`$this->context->getPropertyFromAspect('language', 'contentId');`

    Returns the language ID of records to be fetched in translation scenarios as
    integer (uid).

..  confval:: fallbackChain

    :Call: :php:`$this->context->getPropertyFromAspect('language', 'fallbackChain');`

    Returns the fallback steps as array.

..  confval:: overlayType

    :Call: :php:`$this->context->getPropertyFromAspect('language', 'overlayType');`

    Returns one of

    *   :php:`LanguageAspect::OVERLAYS_OFF`
    *   :php:`LanguageAspect::OVERLAYS_MIXED`
    *   :php:`LanguageAspect::OVERLAYS_ON` or
    *   :php:`LanguageAspect::OVERLAYS_ON_WITH_FLOATING` (default)

    See :ref:`context_api_aspects_language_overlay-types` for more details.

..  confval:: legacyLanguageMode

    :Call: :php:`$this->context->getPropertyFromAspect('language', 'legacyLanguageMode');`

    Returns one of

    *   `strict`
    *   `ignore` or
    *   `content_fallback`.

    This property is kept for compatibility reasons. Do not use, if not really
    necessary, the option will be removed rather sooner than later.

..  confval:: legacyOverlayType

    :Call: :php:`$this->context->getPropertyFromAspect('language', 'legacyOverlayType');`

    Returns one of

    *   `hideNonTranslated`
    *   `0` or
    *   `1`.

    This property is kept for compatibility reasons. Do not use, if not really
    necessary, the option will be removed rather sooner than later.


..  _context_api_aspects_language_overlay-types:

Overlay types
~~~~~~~~~~~~~

:php:`LanguageAspect::OVERLAYS_OFF`
    Just fetch records from the selected language as given by
    :php:`$GLOBALS['TSFE']->sys_language_content`. No overlay will happen, no
    fetching of the records from the default language. This boils down to
    "free mode" language handling. Records without a default language parent are
    included.

:php:`LanguageAspect::OVERLAYS_MIXED`
    Fetch records from the default language and overlay them with translations.
    If a record is not translated, the default language will be used.

:php:`LanguageAspect::OVERLAYS_ON`
    Fetch records from the default language and overlay them with translations.
    If a record is not translated, it will not be displayed.

:php:`LanguageAspect::OVERLAYS_ON_WITH_FLOATING`
    Fetch records from the default language and overlay them with translations.
    If a record is not translated, it will not be shown. Records without a
    default language parent are included.

..  _context_api_aspects_language_example:

Example
~~~~~~~

..  literalinclude:: _MyControllerUsingLanguageAspect.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php


..  _context_api_aspects_preview:

Preview aspect
--------------

The preview aspect may be used to indicate that the frontend is in preview mode
(for example, in case a workspace is previewed or hidden pages or records should
be shown).

..  _context_api_aspects_preview_properties:

The preview aspect, :php:`\TYPO3\CMS\Frontend\Aspect\PreviewAspect`, contains
the following property:

..  confval:: isPreview

    :Call: :php:`$this->context->getPropertyFromAspect('frontend.preview', 'isPreview');`

Returns, whether the frontend is currently in preview mode.


..  _context_api_aspects_typoscript:

TypoScript aspect
-----------------

The TypoScript aspect can be used to manipulate/check whether
TemplateRendering is forced.

..  _context_api_aspects_typoscript_properties:

The TypoScript aspect, `\TYPO3\CMS\Core\Context\TypoScriptAspect` contains the
following property:

..  confval:: forcedTemplateParsing

    :Call: :php:`$this->context->getPropertyFromAspect('typoscript', 'forcedTemplateParsing');`

    Returns, whether TypoScript template parsing is forced.


..  _context_api_aspects_user:

User aspect
-----------

Contains information about authenticated users in the current
:ref:`request <typo3-request>`. The aspect can be used for frontend and backend
users.

..  _context_api_aspects_user_properties:

The user aspect, :php:`\TYPO3\CMS\Core\Context\UserAspect`, accepts the
following properties:

..  confval:: id

    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'id');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'id');`

    Returns the uid of the currently logged in user, `0` if no user is logged
    in.

..  confval:: username

    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'username');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'username');`

    Returns the username of the currently authenticated user. Empty string, if
    no user is logged in.

..  confval:: isLoggedIn

    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'isLoggedIn');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'isLoggedIn');`

    Returns, whether a user is logged in, as boolean.

..  confval:: isAdmin

    :Call: :php:`$this->context->getPropertyFromAspect('backend.user', 'isAdmin');`

    Returns, whether the user is an administrator, as boolean. It is only useful
    for backend users.

..  confval:: groupIds

    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'groupIds');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'groupIds');`

    Returns the groups the user is a member of, as array.

..  confval:: groupNames

    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'groupNames');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'groupNames');`

    Returns the names of all groups the user belongs to, as array.

..  _context_api_aspects_user_example:

Example
~~~~~~~

..  literalinclude:: _MyControllerUsingUserAspect.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php


..  _context_api_aspects_visibility:

Visibility aspect
-----------------

The aspect contains whether to show hidden pages, records (content) or even
deleted records.


..  _context_api_aspects_visibility_properties:

The visibility aspect, :php:`\TYPO3\CMS\Core\Context\VisibilityAspect`, accepts
the following properties:

..  confval:: includeHiddenPages

    :Call: :php:`$this->context->getPropertyFromAspect('visibility', 'includeHiddenPages');`

    Returns, whether hidden pages should be displayed, as boolean.

..  confval:: includeHiddenContent

    :Call: :php:`$this->context->getPropertyFromAspect('visibility', 'includeHiddenContent');`

    Returns, whether hidden content should be displayed, as boolean.

..  confval:: includeDeletedRecords

    :Call: :php:`$this->context->getPropertyFromAspect('visibility', 'includeDeletedRecords');`

    Returns, whether deleted records should be displayed, as boolean.


..  _context_api_aspects_visibility_example:

Example
~~~~~~~

..  literalinclude:: _MyControllerUsingVisibilityAspect.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php


..  _context_api_aspects_workspace:

Workspace aspect
----------------

The aspect contains information about the currently accessed
:ref:`workspace <workspaces>`.

..  _context_api_aspects_workspace_properties:

The workspace aspect, :php:`\TYPO3\CMS\Core\Context\WorkspaceAspect`, accepts
the following properties:

..  confval:: id

    :Call: :php:`$this->context->getPropertyFromAspect('workspace', 'id');`

    Returns the UID of the currently accessed workspace, as integer.

..  confval:: isLive

    :Call: :php:`$this->context->getPropertyFromAspect('workspace', 'isLive');`

    Returns whether the current workspace is live, or a custom offline
    workspace, as boolean.

..  confval:: isOffline

    :Call: :php:`$this->context->getPropertyFromAspect('workspace', 'isOffline');`

    Returns, whether the current workspace is offline, as boolean.

..  _context_api_aspects_workspace_example:

Example
~~~~~~~

..  literalinclude:: _MyControllerUsingWorkspaceAspect.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php
