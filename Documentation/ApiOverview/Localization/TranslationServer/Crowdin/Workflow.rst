:navigation-title: Workflow

..  include:: /Includes.rst.txt
..  index::
    Workflow
    pair: Crowdin; Workflow
..  _crowdin-workflow:

=================================================================
Workflow: From new Crowdin translations to the TYPO3 installation
=================================================================

The following workflow is used to bring a translation into a TYPO3 installation.

..  rst-class:: bignums

#.  English sources

    The sources in English are maintained in the project itself.

#.  Creating translations on Crowdin.com

    The translations for the TYPO3 Core are managed on Crowdin at
    https://crowdin.com/project/typo3-cms.

    You can either translate all strings on the Crowdin platform or directly in
    the TYPO3 backend.

    You can find the status of translations for TYPO3 Core and extensions here:
    https://localize.typo3.org/xliff/status.html

#.  Crowdin Bridge

    A separate project is accountable for exporting the translations from Crowdin.
    This consists of several steps:

    *   Trigger a build of all projects
    *   Download all translations including multiple branches and all available languages
    *   Create ZIP files of all single :ref:`XLIFF <xliff>` files
    *   Copy the files to the translation server

    The Crowdin Bridge is available under https://github.com/TYPO3/crowdin-bridge.

#.  Import translations into TYPO3 installations

    The translations can be downloaded within a TYPO3 installation.
    This is described under :ref:`xliff-translating-fetch`.

..  code-block:: text

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
