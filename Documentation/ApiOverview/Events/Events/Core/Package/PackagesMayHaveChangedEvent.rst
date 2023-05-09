..  include:: /Includes.rst.txt
..  index:: Events; PackagesMayHaveChangedEvent
..  _PackagesMayHaveChangedEvent:

===========================
PackagesMayHaveChangedEvent
===========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Package\Event\PackagesMayHaveChangedEvent`
is a marker event to ensure that Core is re-triggering the package ordering and
package listings.

API
===

..  include:: /CodeSnippets/Events/Core/PackagesMayHaveChangedEvent.rst.txt
