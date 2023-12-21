..  include:: /Includes.rst.txt
..  index:: TSFE; TypoScriptFrontendController
..  _tsfe:

====
TSFE
====

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
only available in frontend contexts, not in the backend or CLI.

Initializing :php:`$GLOBALS['TSFE']` in the backend is sometimes done in code
examples found online. This is not recommended. TSFE is not initialized in the
backend context by the Core (and there is usually no need to do this).

From the PHP documentation:

    As of PHP 8.1.0, $GLOBALS is now a read-only copy of the global symbol table.
    That is, global variables cannot be modified via its copy.

https://www.php.net/manual/en/reserved.variables.globals.php

Howtos
======

Following are some examples which use TSFE and alternatives to using TSFE,
where available:

..  _tsfe_ContentObjectRenderer:

Access ContentObjectRenderer
----------------------------

Access the :php:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`
(often referred to as "cObj"):

..  code-block:: php

    // !!! discouraged
    $cObj = $GLOBALS['TSFE']->cObj;

Obtain TSFE from request attribute 'frontend.controller':

..  code-block:: php

    $frontendController = $request->getAttribute('frontend.controller');
    $cObj = $frontendController->cObj;

In the case of :ref:`user function <tsref:cobj-user-int>` (for example, a non-Extbase plugin) via setter injection:

..  code-block:: php

    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }

..  _tsfe_pageId:

Access current page ID
----------------------

Access the current page ID:

.. code-block:: php

    // !!! discouraged
    $pageId = $GLOBALS['TSFE']->id;

Can be done using the :ref:`'routing' <typo3-request-attribute-routing>`
request attribute:

..  code-block:: php

    $pageArguments = $request->getAttribute('routing');
    $pageId = $pageArguments->getPageId();

..  _tsfe_frontendUser:

Access frontend user information
--------------------------------

..  code-block:: php

    // !!! discouraged
    $feUser = $GLOBALS['TSFE']->fe_user;

Use the :ref:`frontend.user <typo3-request-attribute-frontend-user>`:

..  code-block:: php

    /** @var \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication $frontendUser */
    $frontendUser = $request->getAttribute('frontend.user');

Some information via frontend and backend users con be obtained via the
:ref:`user aspect <context_api_aspects_user>`. For example:

..  code-block:: php

    // return whether a frontend user is logged in
    $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');

..  _tsfe_baseURL:

Get current base URL
--------------------

It used to be possible to get the base URL configuration (from TypoScript
:typoscript:`config.baseURL`) with the :php:`TSFE` :php:`baseURL` property. The
property is now protected and deprecated since TYPO3 v12. Already in
earlier version, site configuration should be used to get the base URL
of the current site.

..  code-block:: php

    // !!! deprecated
    $GLOBALS['TSFE']->baseURL

..  code-block:: php

    /** @var \TYPO3\CMS\Core\Site\Entity\Site $site */
    $site = $request->getAttribute('site');
    // array
    $siteConfiguration = $site->getConfiguration();
    $baseUrl = $siteConfiguration['base'];
