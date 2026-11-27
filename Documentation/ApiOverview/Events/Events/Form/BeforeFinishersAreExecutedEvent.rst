..  include:: /Includes.rst.txt
..  index:: Events; BeforeFinishersAreExecutedEvent

..  _BeforeFinishersAreExecutedEvent:

=================================
`BeforeFinishersAreExecutedEvent`
=================================

..  versionadded:: 15.0
    :changelog: feature-111101-1792188000

The event :php:`\TYPO3\CMS\Form\Event\BeforeFinishersAreExecutedEvent`
is dispatched once a form was submitted successfully: after the last page
is validated and before the finishers of the form run. A listener can react
to the submission, for example to notify an external system.

The finishers of this submission are in `$finishers`, in the order they run.
A listener can remove, reorder, or add finishers. This changes only the
current submission, not the form definition. The form runtime is available
in `$formRuntime`, and the finisher context, which every finisher receives,
in `$finisherContext`. Variables that a listener adds to the finisher
variable provider of the context are available to the finishers.

..  _BeforeFinishersAreExecutedEvent-example:

Example: Skip the confirmation email when the user declines it
==============================================================

The form `newsletterSignup` has a field `sendConfirmationEmail`. If the user
sets it to `no`, the following listener removes the finisher
`EmailToSender`, which sends the confirmation email. All other finishers
still run:

..  literalinclude:: _BeforeFinishersAreExecutedEvent/_SkipConfirmationEmailListener.php
    :caption: EXT:my_extension/Classes/EventListener/SkipConfirmationEmailListener.php

..  _BeforeFinishersAreExecutedEvent-api:

API of `BeforeFinishersAreExecutedEvent`
========================================

..  typo3:api-class:: \TYPO3\CMS\Form\Event\BeforeFinishersAreExecutedEvent
