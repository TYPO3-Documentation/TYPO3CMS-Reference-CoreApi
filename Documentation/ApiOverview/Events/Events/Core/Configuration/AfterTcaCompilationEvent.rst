..  include:: /Includes.rst.txt
..  index:: Events; AfterTcaCompilationEvent
..  _AfterTcaCompilationEvent:

========================
AfterTcaCompilationEvent
========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\AfterTcaCompilationEvent` is
dispatched after :php:`$GLOBALS['TCA']` is built to allow to further manipulate
the :ref:`TCA <t3tca:start>`.

..  note::
    It is possible to check against the original TCA as this is stored within
    :php:`$GLOBALS['TCA']` before this event is fired.

API
===

..  include:: /CodeSnippets/Events/Core/AfterTcaCompilationEvent.rst.txt
