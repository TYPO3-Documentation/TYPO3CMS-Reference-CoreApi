..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend TypoScript
..  _typo3-request-attribute-frontend-typoscript:

===================
Frontend TypoScript
===================

The :php:`frontend.typoscript` frontend request attribute provides access to the
:php:`\TYPO3\CMS\Core\TypoScript\FrontendTypoScript` object. It contains
the calculated TypoScript :php:`settings` (formerly :php:`constants`) and
sometimes :php:`setup`, depending on page cache status.

When a content object or plugin (plugins are content objects as well) needs the
current TypoScript, it can retrieve it using this API:

..  code-block:: php

    // Substitution of $GLOBALS['TSFE']->tmpl->setup
    $fullTypoScript = $request->getAttribute('frontend.typoscript')
        ->getSetupArray();

API
===

..  versionadded:: 13.0
    The method :php:`getConfigArray()` has been added. This supersedes the
    :php:`TSFE->config['config']` array.

..  include:: /CodeSnippets/Manual/Entity/FrontendTypoScript.rst.txt
