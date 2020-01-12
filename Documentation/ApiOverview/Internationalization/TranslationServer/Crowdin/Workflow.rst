.. include:: ../../../../Includes.txt


.. _crowdin-workflow:

========
Workflow
========

The following workflow is used to bring a translation into a TYPO3 installation.

.. rst-class:: bignums

1. English Sources

   The sources in English are maintained in the project itself.

2. Creating translations on Crowdin.com

   The translations are managed on Crowdin at https://crowdin.com/project/typo3-cms.

   You can either translate all strings on the Crowdin platform or directly in the TYPO3 backend.

   .. todo:: Add link to usage

3. Crowdin Bridge

   A separate project is accountable for exporting the translations from Crowdin.
   This consists of several steps:

   - Trigger a build of all projects
   - Download all translations including multiple branches and all available languages
   - Create zip files of all single xlf files
   - Copy the files to the translation server

   .. todo:: Link to the project

4. Import translations into TYPO3 installations

   The translations can be downloaded within a TYPO3 installation.
   This is described at :ref:`xliff-translating-fetch`.

Chart
=====

.. code-block:: text

      +--------------+                   +----------------+
      |  1) GitHub   |                   | 2) Crowdin.com |
      |--------------|                   |----------------|
      |              |  Automated Sync   |- Translate     |
      | TYPO3 Core   |+----------------> |- Proofread     |
      |  and         |                   |                |
      | Extensions   |                   | in all         |
      |              |                   | languages      |
      +--------------+                   +----------------+
                                                ^
                                                |
        +---------------------------------------+
        |Triggered via GitHub actions
        v
      +-------------------+                 +-----------------------+
      | 3) Crowdin Bridge |                 | 4) Translation Server |
      |-------------------|                 |-----------------------|
      |- Build projects   |                 |- Serves l10n zip      |
      |- Download         |     rsync to    |  files, requested     |
      |  translations     |+--------------->|  by TYPO3 sites       |
      |- Create zips      |                 |- Hosts status page    |
      |- Status pages     |                 +-----------------------+
      +-------------------+
