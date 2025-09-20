..  include:: /Includes.rst.txt
..  _major:

=============
Major upgrade
=============

..  figure:: /Images/ManualScreenshots/Backend/Typo3Version.png
    :alt: The top bar of a TYPO3 backend showing the current version being used.

    You can find the current TYPO3 Core version in the top left of the TYPO3 backend.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Pre-upgrade tasks <PreupgradeTasks>`

        Before upgrading TYPO3 to a major release, there are several tasks that can be performed
        to help ensure a successful upgrade and help minimise any potential downtime.

    ..  card:: :ref:`Upgrade the Core <UpgradeCore>`

        This chapter details how to perform a major upgrade using Composer.

    ..  card:: :ref:`Post-upgrade tasks <PostUpgradeTasks>`

        Once TYPO3's Core has been upgraded, there are a few tasks that need to be followed
        to complete the process.

..  toctree::
    :hidden:
    :titlesonly:

    Version14
    PreupgradeTasks/Index
    UpgradeCore
    PostupgradeTasks/Index
