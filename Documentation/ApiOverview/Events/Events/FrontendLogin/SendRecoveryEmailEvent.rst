..  include:: /Includes.rst.txt
..  index:: Events; SendRecoveryEmailEvent
..  _SendRecoveryEmailEvent:


======================
SendRecoveryEmailEvent
======================

The PSR-14 event :php:`\TYPO3\CMS\FrontendLogin\Event\SendRecoveryEmailEvent`
contains the email to be sent and additional information about the user who
requested a new password.

..  hint::
    Before TYPO3 v13, only the variables :html:`{receiverName}`, :html:`{url}`
    and :html:`{validUntil}` are available in the Fluid template of the password
    recovery email. If more user-related data was required in the recovery email,
    integrators had to use this PSR-14 event to add additional variables to the
    email object.

    Since TYPO3 v13, a new array variable :html:`{userData}` is available in
    the password recovery :php:`FluidEmail` object. It contains the values of
    all fields belonging to the affected frontend user. Therefore, for this
    use case, this event is not needed anymore.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/SendRecoveryEmailEvent.rst.txt
