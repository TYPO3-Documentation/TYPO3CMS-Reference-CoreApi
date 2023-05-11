..  include:: /Includes.rst.txt
..  index:: Events; BeforePackageActivationEvent
..  _BeforePackageActivationEvent:

============================
BeforePackageActivationEvent
============================

The PSR-14 event :php:`\TYPO3\CMS\Core\Package\Event\BeforePackageActivationEvent`
is triggered before a number of packages should become active.

..  attention::
    This event is dispatched before an extension is activated in the
    :guilabel:`Extension Manager`, therefore starting with TYPO3 v11 this
    event is only dispatched in legacy installations, not in composer-based
    installations. Use
    `installer events by composer <https://getcomposer.org/doc/articles/scripts.md#installer-events>`__
    for composer-based installations.


API
===

..  include:: /CodeSnippets/Events/Core/BeforePackageActivationEvent.rst.txt
