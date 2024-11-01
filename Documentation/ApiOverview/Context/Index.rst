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

The context is set up at the very beginning of each TYPO3 entry point, keeping
track of, for example, the current time, if a user is logged in and which
workspace is currently accessed.

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
    :name: datetime-aspect-timestamp
    :Call: :php:`$this->context->getPropertyFromAspect('date', 'timestamp');`

    Returns the Unix timestamp as an integer value.

..  confval:: timezone
    :name: datetime-aspect-timezone
    :Call: :php:`$this->context->getPropertyFromAspect('date', 'timezone');`

    Returns the timezone name, for example, "Germany/Berlin".

..  confval:: iso
    :name: datetime-aspect-iso
    :Call: :php:`$this->context->getPropertyFromAspect('date', 'iso');`

    Returns the datetime as string in
    `ISO 8601 <https://en.wikipedia.org/wiki/ISO_8601>`__ format, for example,
    "2004-02-12T15:19:21+00:00".

..  confval:: full
    :name: datetime-aspect-full
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
    :name: language-aspect-id
    :Call: :php:`$this->context->getPropertyFromAspect('language', 'id');`

    Returns the requested language of the current page as integer (uid).

..  confval:: contentId
    :name: language-aspect-contentId
    :Call: :php:`$this->context->getPropertyFromAspect('language', 'contentId');`

    Returns the language ID of records to be fetched in translation scenarios as
    integer (uid).

..  confval:: fallbackChain
    :name: language-aspect-fallbackChain
    :Call: :php:`$this->context->getPropertyFromAspect('language', 'fallbackChain');`

    Returns the fallback steps as array.

..  confval:: overlayType
    :name: language-aspect-overlayType
    :Call: :php:`$this->context->getPropertyFromAspect('language', 'overlayType');`

    Returns one of

    *   :php:`LanguageAspect::OVERLAYS_OFF`
    *   :php:`LanguageAspect::OVERLAYS_MIXED`
    *   :php:`LanguageAspect::OVERLAYS_ON` or
    *   :php:`LanguageAspect::OVERLAYS_ON_WITH_FLOATING` (default)

    See :ref:`context_api_aspects_language_overlay-types` for more details.

..  confval:: legacyLanguageMode
    :name: language-aspect-legacyLanguageMode
    :Call: :php:`$this->context->getPropertyFromAspect('language', 'legacyLanguageMode');`

    Returns one of

    *   `strict`
    *   `ignore` or
    *   `content_fallback`.

    This property is kept for compatibility reasons. Do not use, if not really
    necessary, the option will be removed rather sooner than later.

..  confval:: legacyOverlayType
    :name: language-aspect-legacyOverlayType
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
    :php:`LanguageAspect->getContentId()`. No overlay will happen, no
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
    :name: Preview-aspect-isPreview
    :Call: :php:`$this->context->getPropertyFromAspect('frontend.preview', 'isPreview');`

Returns, whether the frontend is currently in preview mode.


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
    :name: user-aspect-id
    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'id');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'id');`

    Returns the uid of the currently logged in user, `0` if no user is logged
    in.

..  confval:: username
    :name: user-aspect-username
    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'username');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'username');`

    Returns the username of the currently authenticated user. Empty string, if
    no user is logged in.

..  confval:: isLoggedIn
    :name: user-aspect-isLoggedIn
    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'isLoggedIn');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'isLoggedIn');`

    Returns, whether a user is logged in, as boolean.

..  confval:: isAdmin
    :name: user-aspect-isAdmin
    :Call: :php:`$this->context->getPropertyFromAspect('backend.user', 'isAdmin');`

    Returns, whether the user is an administrator, as boolean. It is only useful
    for backend users.

..  confval:: groupIds
    :name: user-aspect-groupIds
    :Call: :php:`$this->context->getPropertyFromAspect('frontend.user', 'groupIds');` or :php:`$this->context->getPropertyFromAspect('backend.user', 'groupIds');`

    Returns the groups the user is a member of, as array.

..  confval:: groupNames
    :name: user-aspect-groupNames
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
    :name: visibility-aspect-includeHiddenPages
    :Call: :php:`$this->context->getPropertyFromAspect('visibility', 'includeHiddenPages');`

    Returns, whether hidden pages should be displayed, as boolean.

..  confval:: includeHiddenContent
    :name: visibility-aspect-includeHiddenContent
    :Call: :php:`$this->context->getPropertyFromAspect('visibility', 'includeHiddenContent');`

    Returns, whether hidden content should be displayed, as boolean.

..  confval:: includeDeletedRecords
    :name: visibility-aspect-includeDeletedRecords
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
    :name: workspace-aspect-id
    :Call: :php:`$this->context->getPropertyFromAspect('workspace', 'id');`

    Returns the UID of the currently accessed workspace, as integer.

..  confval:: isLive
    :name: workspace-aspect-isLive
    :Call: :php:`$this->context->getPropertyFromAspect('workspace', 'isLive');`

    Returns whether the current workspace is live, or a custom offline
    workspace, as boolean.

..  confval:: isOffline
    :name: workspace-aspect-isOffline
    :Call: :php:`$this->context->getPropertyFromAspect('workspace', 'isOffline');`

    Returns, whether the current workspace is offline, as boolean.

..  _context_api_aspects_workspace_example:

Example
~~~~~~~

..  literalinclude:: _MyControllerUsingWorkspaceAspect.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php
