..  include:: /Includes.rst.txt
..  index:: Events; AfterTemplatesHaveBeenDeterminedEvent
..  _AfterTemplatesHaveBeenDeterminedEvent:

=====================================
AfterTemplatesHaveBeenDeterminedEvent
=====================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\TypoScript\IncludeTree\Event\AfterTemplatesHaveBeenDeterminedEvent`
can be used to manipulate :sql:`sys_template` rows. The event receives the list
of resolved :sql:`sys_template` rows and the
:php:`\Psr\Http\Message\ServerRequestInterface` and allows manipulating the
:sql:`sys_template` rows array.

The event is called in the code of the :guilabel:`Sites > TypoScript`
backend module, for example in the submodule :guilabel:`Included TypoScript`,
and in the frontend.

Extensions using the old hook that want to stay compatible with TYPO3 v11
and v12 can implement both the hook and the event.

Example
=======

..  literalinclude:: _AfterTemplatesHaveBeenDeterminedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/TypoScript/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/AfterTemplatesHaveBeenDeterminedEvent.rst.txt
