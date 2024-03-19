..  include:: /Includes.rst.txt

..  index::
    Request attribute; Language
..  _typo3-request-attribute-language:

========
Language
========

The :php:`language` frontend request attribute provides information about the
current language of the webpage via the
:php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage` object.

Example:

..  code-block:: php

    $language = $request->getAttribute('language');
    $locale = $language->getLocale();


..  seealso::
    For the API see :php:class:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage`.
