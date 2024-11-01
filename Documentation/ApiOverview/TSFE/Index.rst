..  include:: /Includes.rst.txt
..  index:: TSFE; TypoScriptFrontendController
..  _tsfe:

====
TSFE
====

..  deprecated:: 13.4
    The class :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`
    and its global instance :php:`$GLOBALS['TSFE']` have been marked as
    deprecated. The class will be removed with TYPO3 v14.

..  contents::
    :local:

What is TSFE?
=============

TSFE is short for :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`,
a class which exists in the system extension EXT:frontend.

As the name implies: A responsibility of TSFE
is page rendering. It also handles reading from and writing to the page cache.
For more details it is best to look into the source code.

There are several contexts in which the term TSFE is used:

*   PHP: It is passed as request attribute
    :ref:`frontend.controller <typo3-request-attribute-frontend-controller>`
*   PHP: It was and is available as global array :php:`$GLOBALS['TSFE']` in PHP.
*   TypoScript: TypoScript function :ref:`TSFE <t3tsref:data-type-gettext-tsfe>`
    which can be used to access public properties in TSFE.

The TypoScript part is covered in the
:ref:`TypoScript Reference: TSFE <t3tsref:data-type-gettext-tsfe>`.
In this section we focus on the PHP part and give an overview, in which way the
TSFE class can be used.

Accessing TSFE
==============

..  attention::

    Some of the former public properties and methods have been changed to
    protected or marked as internal. Often, accessing TSFE is no longer
    necessary, and there are better alternatives.

    Access :php:`$GLOBALS['TSFE']` directly only as a last resort,
    usage is strongly discouraged, if not absolutely necessary.

From the source:

    When calling a frontend page, an instance of this object is available
    as :php:`$GLOBALS['TSFE']`, even though the Core development strives to get
    rid of this in the future.

If access to the
:php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` instance is
necessary, use the request attribute
:ref:`frontend.controller <typo3-request-attribute-frontend-controller>`:

..  code-block:: php

    $frontendController = $request->getAttribute('frontend.controller');

..  seealso::
    :ref:`getting-typo3-request-object`

TSFE is not available in all contexts. In particular, it is
only available in frontend contexts, not in the backend or the
:ref:`command line <symfony-console-commands>`.

Initializing :php:`$GLOBALS['TSFE']` in the backend is sometimes done in code
examples found online. This is not recommended. TSFE is not initialized in the
backend context by the Core (and there is usually no need to do this).

From the PHP documentation:

    As of PHP 8.1.0, $GLOBALS is now a read-only copy of the global symbol table.
    That is, global variables cannot be modified via its copy.

    -- https://www.php.net/manual/en/reserved.variables.globals.php

Howtos
======

Following are some examples which use TSFE and alternatives to using TSFE,
where available:

..  _tsfe_ContentObjectRenderer:

Access ContentObjectRenderer
----------------------------

..  versionchanged:: 13.0
    This property has been marked as read-only.

Access the :php:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`
(often referred to as "cObj"):

..  code-block:: php

    // !!! discouraged
    $cObj = $GLOBALS['TSFE']->cObj;

Obtain the current content object in an Extbase controller from the request attribute
:ref:`currentContentObject <typo3-request-attribute-current-content-object>`:

..  code-block:: php

    $currentContentObject = $request->getAttribute('currentContentObject');

In the case of the :ref:`USER content object <t3tsref:cobj-user>` (for example,
a non-Extbase plugin) use setter injection:

..  literalinclude:: _MyClass.php
    :language: php
    :caption: EXT:my_extension/Classes/UserFunctions/MyClass.php

..  _tsfe_pageId:

Access current page ID
----------------------

..  versionchanged:: 13.0
    This property has been marked as read-only.

Access the current page ID:

.. code-block:: php

    // !!! discouraged
    $pageId = $GLOBALS['TSFE']->id;

Instead, the current page ID can be retrieved using the
:ref:`routing request attribute <typo3-request-attribute-routing>`:

..  code-block:: php

    $pageArguments = $request->getAttribute('routing');
    $pageId = $pageArguments->getPageId();

..  versionadded:: 13.0

Or, alternatively with the :ref:`frontend.page.information request attribute
<typo3-request-attribute-frontend-page-information>`:

..  code-block:: php

    $pageInformation = $request->getAttribute('frontend.page.information');
    $pageId = $pageInformation->getId();


..  _tsfe_frontendUser:

Access frontend user information
--------------------------------

..  versionchanged:: 13.0
    The variable :php:`$GLOBALS['TSFE']->fe_user` has been removed with TYPO3
    v13. :ref:`Migration <t3tsref:appendix-include-tsfe-feuser>`.


..  _tsfe_baseURL:

Get current base URL
--------------------

..  versionchanged:: 13.0
    The variable :php:`$GLOBALS['TSFE']->baseURL` has been removed with TYPO3
    v13.

Use the :ref:`request object <typo3-request>` and retrieve the
:ref:`site attribute <typo3-request-attribute-site>` which holds the
:ref:`site configuration <sitehandling-create-new>`:

..  code-block:: php

    /** @var \TYPO3\CMS\Core\Site\Entity\Site $site */
    $site = $request->getAttribute('site');
    /** @var array $siteConfiguration */
    $siteConfiguration = $site->getConfiguration();
    $baseUrl = $siteConfiguration['base'];
