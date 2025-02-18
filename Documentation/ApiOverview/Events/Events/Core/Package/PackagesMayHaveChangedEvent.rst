..  include:: /Includes.rst.txt
..  index:: Events; PackagesMayHaveChangedEvent
..  _PackagesMayHaveChangedEvent:

===========================
PackagesMayHaveChangedEvent
===========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Package\Event\PackagesMayHaveChangedEvent`
is a marker event to ensure that Core is re-triggering the package ordering and
package listings.

..  attention::
    This event is dispatched when an extension is changed in the
    :guilabel:`Extension Manager`, therefore starting with TYPO3 v11 this
    event is only dispatched in legacy installations, not in Composer-based
    installations. Use
    `installer events by Composer <https://getcomposer.org/doc/articles/scripts.md#installer-events>`__
    for Composer-based installations.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/PackagesMayHaveChangedEvent.rst.txt
