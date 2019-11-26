.. include:: ../../../Includes.txt


.. _xliff-translating-server-crowdin:

=========================
Localization with Crowdin
=========================

.. tip::

   The integration of Crowdin is currently in beta state. Once it is stabilized, it will be also available in installations using TYPO3 9 LTS.

What is Crowdin
---------------

TODO

- What is crowdin
- Iniative
- Contact

Workflow
--------


#. Creating translations

   The translations are managed either on Crowdin or directly in the TYPO3 backend. This is described in detail at :ref:`crowdin-usage`.

#. Export

   Once the translations are approved, those are automatically exported to the translation server `beta-translation.typo3.org`.

   TODO: Add link to repo.

#. Import translations into TYPO3 installations

   The translations can be downloaded which is described at :ref:`xliff-translating-fetch`.

More
----

.. toctree::
   :titlesonly:

   Crowdin/Usage
   Crowdin/ExtensionIntegration
