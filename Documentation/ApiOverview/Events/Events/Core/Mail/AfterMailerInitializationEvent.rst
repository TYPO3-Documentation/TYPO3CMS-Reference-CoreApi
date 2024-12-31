..  include:: /Includes.rst.txt
..  index:: Events; AfterMailerInitializationEvent
..  _AfterMailerInitializationEvent:

==============================
AfterMailerInitializationEvent
==============================

..  warning::
    The event :php:`\TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent`
    will be removed in v14.

    This event became useless with the introduction of the symfony
    based mailer in TYPO3 v10 and was only able to influence the core handling by
    calling the :php:`@internal` marked method :php:`injectMailSettings()` *after* the
    settings have already been determined within the core mailer. The event has been
    removed since it did not fit a useful use case anymore.
