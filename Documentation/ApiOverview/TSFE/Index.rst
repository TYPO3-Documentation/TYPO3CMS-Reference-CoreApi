.. include:: /Includes.rst.txt
.. index:: TSFE; TypoScriptFrontendController
.. _tsfe:

====
TSFE
====

What is TSFE?
=============

TSFE is short for :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`,
a class which exists in the system extension EXT:frontend.

As the name implies: A responsibility of TSFE
is page rendering. It also handles reading from and writing to the page cache.
For more details it is best to look in the source code.

There are several contexts in which the term TSFE is used:

1.  PHP: It is passed as request attribute
    :ref:`frontend.controller <typo3-request-attribute-frontend-controller>`
2.  PHP: It was and is available as global array :php:`$GLOBALS['TSFE']` in PHP.
3.  TypoScript: TypoScript function :ref:`TSFE <t3tsref:data-type-gettext-tsfe>`
    which can be used to access public properties in TSFE.
4.  (deprecated since v9.5 and :doc:`removed in 10.0
    <ext_core:Changelog/10.0/Breaking-88564-PageTSconfigSettingTSFEconstantsRemoved>`)
    Page TSconfig: :typoscript:`TSFE.constants`.

Focusing on the PHP part (as the TypoScript part is covered in the
:ref:`TypoScript Reference: TSFE <t3tsref:data-type-gettext-tsfe>` page),
this page gives an overview, what can still be used, what is deprecated,
removed or discouraged and in which way the TSFE class itself may be
interesting to developers.

Accessing TSFE
===============

.. attention::

    Some of the former public properties and methods have been changed to
    protected or marked as internal. Often, accessing TSFE is no longer
    necessary, and there are better alternatives.

    Directly access :php:`$GLOBALS['TSFE']` only as a last resort. It is
    strongly discouraged if not absolutely necessary.

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

.. add howtos for common use cases, remove the not recommended, deprecated
.. way if there is a better way

Following are some examples which use TSFE and alternatives to using TSFE,
where available:

.. _tsfe_ContentObjectRenderer:

Access ContentObjectRenderer
----------------------------

Access the :php:`ContentObjectRenderer` (often referred to as "cObj"):

.. code-block:: php

    // this is discouraged, obtain TSFE from request attribute 'frontend.controller'
    // see next example
    $cObj = $GLOBALS['TSFE']->cObj;

.. code-block:: php

    $frontendController = $request->getAttribute('frontend.controller');
    $cObj = $frontendController->cObj;

In the case of a non Extbase plugin via setter injection:

.. code-block:: php

    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }

.. _tsfe_pageId:

Access current page id
----------------------

Access the current page id:

.. code-block:: php

    // this is discouraged
    $GLOBALS['TSFE']->id

Can be done using the :ref:`'routing' <typo3-request-attribute-routing>`
request attribute:

.. code-block:: php

    $pageArguments = $request->getAttribute('routing');
    $pageId = $pageArguments->getPageId();

.. _tsfe_language:

Access language settings
------------------------

In order to get current language settings, such as the current language id,
obtain :php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage` object from the
:ref:`request attribute <request-attributes>` 'language':

.. code-block:: php

    // TYPO3\CMS\Core\Site\Entity\SiteLanguage object.
    $language = $request->getAttribute('language');
    $languageId = $language->getLanguageId();


If the request is not available, accessing language settings
can be done using the :ref:`language aspect <context_api_aspects_language>`.

Get the language of the current page as integer:

.. code-block:: php

    $languageId = (int) $context->getPropertyFromAspect('language', 'id');

.. _tsfe_frontendUser

Access frontend user information
--------------------------------

Accessing information about Frontend users. Accessing
:php:`$GLOBALS['TSFE']->fe_user` directly is discouraged.

.. code-block:: php

    // not recommended, use alternatives if possible
    // TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
    $feUser = $GLOBALS['TSFE']->fe_user;

Using :ref:`request-attributes`:

.. code-block:: php

    // TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
    $frontendUser = $request->getAttribute('frontend.user');

Some information via frontend and backend users con be obtained via the
:ref:`user aspect <context_api_aspects_user>`. For example:

.. code-block:: php

    // return whether a frontend user is logged in
    $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');

.. _tsfe_baseURL:

Get current base URL
--------------------

To get the base URL of the current site (or other site configuration), use site
configuration:

.. code-block:: php

    // TYPO3\CMS\Core\Site\Entity\Site
    $site = $request->getAttribute('site');
    // array
    $siteConfiguration = $site->getConfiguration();
    $baseUrl = $siteConfiguration['base'];

.. _tsfe_siteByPageId:

Get site by page id
-------------------

.. code-block:: php

    // TYPO3\CMS\Core\Site\SiteFinder object (e.g. was injected by DI)
    // TYPO3\CMS\Core\Site\Entity\Site
    $site = $this->siteFinder->getSiteByPageId($pageId);

.. seealso::

    :ref:`Site <typo3-request-attribute-site>`
