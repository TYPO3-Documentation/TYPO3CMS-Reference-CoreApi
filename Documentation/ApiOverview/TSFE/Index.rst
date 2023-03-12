.. include:: /Includes.rst.txt
.. index:: TSFE; TypoScriptFrontendController
.. _tsfe:

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

*   PHP: It was and is available as global array :php:`$GLOBALS['TSFE']` in PHP.
*   TypoScript: TypoScript function :ref:`TSFE <t3tsref:data-type-gettext-tsfe>`
    which can be used to access public properties in TSFE.
*   (deprecated since v9.5 and :doc:`removed in 10.0
    <ext_core:Changelog/10.0/Breaking-88564-PageTSconfigSettingTSFEconstantsRemoved>`)
    Page TSconfig: :typoscript:`TSFE.constants`.

The TypoScript part is covered in the
:ref:`TypoScript Reference: TSFE <t3tsref:data-type-gettext-tsfe>`.
In this section we focus on the PHP part and give an overview, in which way the
TSFE class can be used.

Accessing TSFE
===============

.. attention::

    Some of the former public properties and methods have been changed to
    protected or marked as internal. Often, accessing TSFE is no longer
    necessary, and there are better alternatives.

    Access :php:`$GLOBALS['TSFE']` directly only as a last resort,
    usage is strongly discouraged, if not absolutely necessary.

From the source:

    When calling a frontend page, an instance of this object is available
    as :php:`$GLOBALS['TSFE']`, even though the Core development strives to get
    rid of this in the future.

TSFE is not available in all contexts. In particular, it is
only available in frontend contexts, not in the backend or CLI.

Initializing :php:`$GLOBALS['TSFE']` in the backend is sometimes done in code
examples found online. This is not recommended. TSFE is not initialized in the
backend context by the Core (and there is usually no need to do this).

Howtos
======

Following are some examples which use TSFE and alternatives to using TSFE,
where available:

.. _tsfe_ContentObjectRenderer:

Access ContentObjectRenderer
----------------------------

Access the :php:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`
(often referred to as "cObj"):

.. code-block:: php

    // !!! discouraged
    $cObj = $GLOBALS['TSFE']->cObj;

In the case of :ref:`user function <tsref:cobj-user-int>` (for example, a non-Extbase plugin) via setter injection:

.. code-block:: php

    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }

.. _tsfe_pageId:

Access current page ID
----------------------

Access the current page ID:

.. code-block:: php

    // can be used in TYPO3 version 10
    $pageId = $GLOBALS['TSFE']->id;

.. _tsfe_language:

Access language settings
------------------------

In order to get current language settings, such as the current language ID,
obtain :php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage` object from the
:ref:`request attribute <request-attributes>` 'language':

.. code-block:: php

    // can still be used, but will be deprecated
    $languageId = $GLOBALS['TSFE']->sys_language_uid;

Accessing language settings
can be done using the :ref:`language aspect <context_api_aspects_language>`.

Get the language of the current page as integer:

.. code-block:: php

    $languageId = (int) $context->getPropertyFromAspect('language', 'id');

.. _tsfe_frontendUser:

Access frontend user information
--------------------------------

.. code-block:: php

    // TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
    $feUser = $GLOBALS['TSFE']->fe_user;

Some information via frontend and backend users con be obtained via the
:ref:`user aspect <context_api_aspects_user>`. For example:

.. code-block:: php

    // return whether a frontend user is logged in
    $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');

.. _tsfe_baseURL:

Get current base URL
--------------------

It used to be possible to get the base URL configuration (from TypoScript
:typoscript:`config.baseURL`) with the :php:`TSFE` :php:`baseURL` property. The
property will be deprecated in TYPO3 v12. Already in
earlier version, site configuration should be used to get the base URL
of the current site.

.. code-block:: php

    // !!! will be deprecated
    $GLOBALS['TSFE']->baseURL

.. code-block:: php

    // TYPO3\CMS\Core\Site\Entity\Site
    $site = $request->getAttribute('site');
    // array
    $siteConfiguration = $site->getConfiguration();
    $baseUrl = $siteConfiguration['base'];
