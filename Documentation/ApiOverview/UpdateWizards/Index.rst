.. include:: ../../Includes.txt

.. preferably use label "upgrade-wizards"

.. _update-wizards:
.. _upgrade-wizards:

===============
Upgrade Wizards
===============

.. versionadded:: 9.4
   A new API for upgrade wizards was introduced:
   :doc:`t3core:Changelog/9.4/Feature-86076-NewAPIForUpgradeWizards`
   This chapter was updated to use the new API.

TYPO3 CMS offers a way for extension authors to provide automated updates for
extensions. TYPO3 itself provides upgrade wizards to ease updates of TYPO3
versions. This chapter will explain the concept and how to write upgrade
wizards.

The API for upgrade wizards comes with the following interfaces:

* (required) :ref:`UpgradeWizardInterface <upgrade-wizard-interface>`: Main interface for UpgradeWizards. All
  upgrade wizards using the new API MUST implement this interface.
* (optional) :ref:`RepeatableInterface <repeatable-interface>`: Semantic interface to denote wizards that can be repeated
* (optional) :ref:`ChattyInterface <uprade-wizards-chatty-interface>`:  Interface for wizards generating output
* (optional) :php:`ConfirmableInferface`: Interface for wizards that need user confirmation

.. toctree::
   :titlesonly:

   Concept
   Creation
   ExtUpdateFile
