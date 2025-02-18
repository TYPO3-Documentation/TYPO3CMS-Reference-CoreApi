..  include:: /Includes.rst.txt
..  index:: Events; EnrichPasswordValidationContextDataEvent
..  _EnrichPasswordValidationContextDataEvent:


========================================
EnrichPasswordValidationContextDataEvent
========================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\PasswordPolicy\Event\EnrichPasswordValidationContextDataEvent`
allows extensions to enrich the
:t3src:`core/Classes/PasswordPolicy/Validator/Dto/ContextData.php`
:abbr:`DTO (Data Transfer Object)` used in the
:ref:`password policy <password-policies>` validation.

The PSR-14 event is dispatched in all classes where a user password is
validated against the globally configured password policy.

..  note::
    The user data returned by the method :php:`getUserData()` will include user
    data available from the initiating class only. Therefore, event listeners
    should always consider the initiating class name when accessing data from
    :php:`getUserData()`. If specific user data is not available via
    :php:`getUserData()`, it can possibly be retrieved by a custom database
    query (for example, data from the user table in the password reset process
    by fetching the user with the :php:`uid` given in :php:`getUserData()`
    array).

Example
=======

..  literalinclude:: _EnrichPasswordValidationContextDataEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

.. include:: /CodeSnippets/Events/Core/PasswordPolicy/EnrichPasswordValidationContextDataEvent.rst.txt
