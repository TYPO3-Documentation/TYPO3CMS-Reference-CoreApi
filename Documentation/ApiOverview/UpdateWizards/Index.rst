.. include:: ../../Includes.txt

.. preferably use label "upgrade-wizards"

.. _update-wizards:
.. _upgrade-wizards:

===============
Upgrade Wizards
===============

.. note::

   In TYPO3 9.4, `a new API for upgrade wizards <https://docs.typo3.org/c/typo3/cms-core/master/en-us/Changelog/9.4/Feature-86076-NewAPIForUpgradeWizards.html>`__
   was introduced. This chapter was updated to use the new API.

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
