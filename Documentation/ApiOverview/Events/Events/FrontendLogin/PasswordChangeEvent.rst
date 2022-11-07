.. include:: /Includes.rst.txt
.. index:: Events; PasswordChangeEvent
.. _PasswordChangeEvent:

===================
PasswordChangeEvent
===================

The event contains information about the password that has been set and will be
stored in the database shortly. It allows to mark the password as invalid.

..  note::
    You can find a basic example implementation of a listener to this event
    in the chapter :ref:`extension-development-event-listener`.

API
---

.. include:: /CodeSnippets/Events/FrontendLogin/PasswordChangeEvent.rst.txt
