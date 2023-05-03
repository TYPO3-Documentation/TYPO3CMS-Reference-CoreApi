..  include:: /Includes.rst.txt
..  index:: Events; SendRecoveryEmailEvent
..  _SendRecoveryEmailEvent:


======================
SendRecoveryEmailEvent
======================

The PSR-14 event :php:`\TYPO3\CMS\FrontendLogin\Event\SendRecoveryEmailEvent`
contains the email to be sent and additional information about the user who
requested a new password.

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/SendRecoveryEmailEvent.rst.txt
