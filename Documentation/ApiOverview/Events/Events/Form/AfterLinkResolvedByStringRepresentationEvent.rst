..  include:: /Includes.rst.txt
..  index:: Events; AfterFormDefinitionLoadedEvent
..  _AfterFormDefinitionLoadedEvent:

==============================
AfterFormDefinitionLoadedEvent
==============================

..  versionadded:: 13.0

The PSR-14 event
:php:`\TYPO3\CMS\Form\Mvc\Persistence\Event\AfterFormDefinitionLoadedEvent`
allows extensions to modify loaded form definitions.

The event is dispatched after
:php:`\TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManager` has loaded
the definition either from the cache or the filesystem. In latter case, the
event is dispatched after :php:`FormPersistenceManager` has stored the loaded
definition in cache. This means, it is always possible to modify the cached
version. However, the modified form definition is then overridden by TypoScript,
in case a corresponding
:ref:`formDefinitionOverrides <ext_form:concepts-frontendrendering-translation-arguments>`
exists.


Example
=======

..  literalinclude:: _AfterFormDefinitionLoadedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/LinkHandling/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Form/AfterFormDefinitionLoadedEvent.rst.txt
