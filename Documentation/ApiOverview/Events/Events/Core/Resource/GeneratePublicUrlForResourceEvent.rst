.. include:: /Includes.rst.txt
.. index:: Events; GeneratePublicUrlForResourceEvent
.. _GeneratePublicUrlForResourceEvent:


=================================
GeneratePublicUrlForResourceEvent
=================================

This event is fired before TYPO3 FAL's native URL generation for a Resource is instantiated.

This allows for listeners to create custom links to certain files (e.g. restrictions) for creating
authorized deeplinks.

API
===

.. include:: /CodeSnippets/Events/Core/Resource/GeneratePublicUrlForResourceEvent.rst.txt
