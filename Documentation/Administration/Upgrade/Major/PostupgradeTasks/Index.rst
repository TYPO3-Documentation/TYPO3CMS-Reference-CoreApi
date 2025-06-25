:navigation-title: Post-upgrade

..  include:: /Includes.rst.txt
..  _post-upgrade-clear-caches:
..  _postupgradetasks:

===============================================
Post-upgrade tasks for major TYPO3 Core updates
===============================================

#.  `Flush TYPO3 and PHP Cache <https://docs.typo3.org/permalink/t3coreapi:admin-tools-maintenance-flush-cache>`_
#.  Create missing tables and columns in the
    `Database Analyzer <https://docs.typo3.org/permalink/t3coreapi:admin-tools-maintenance-database-analyzer>`_
#.  Run all `Upgrade wizards <https://docs.typo3.org/permalink/t3coreapi:run_upgrade_wizard>`_
#.  `Change or remove columns and tables in the database analyzer <https://docs.typo3.org/permalink/t3coreapi:database-analyser-remove>`_
#.  `Flush TYPO3 and PHP Cache <https://docs.typo3.org/permalink/t3coreapi:admin-tools-maintenance-flush-cache>`_
    (again)
#.  `Reset backend user preferences <https://docs.typo3.org/permalink/t3coreapi:clear-user-settings>`_
    (optional)
#.  `Update the language packs <https://docs.typo3.org/permalink/t3coreapi:manage-language-packs>`_
#.  `Verify webserver configuration (.htaccess) <https://docs.typo3.org/permalink/t3coreapi:maintain-htaccess>`_

..  _maintain-htaccess:

Verify webserver configuration (.htaccess)
==========================================

After an update, the :file:`.htaccess` file may need adoption for the latest TYPO3
major version (for Apache webservers), :ref:`see details on .htaccess <htaccess>`.

Compare the file :file:`vendor/typo3/cms-install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
(or `.htaccess <https://github.com/TYPO3/typo3/blob/main/typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles/root-htaccess>`__)
with your project's :file:`.htaccess` file and adapt new rules accordingly. If you never
edited the file, copy it over to your project to ensure using the most recent version.

Your project's :file:`.htaccess` file should be under version control and part of your
deployment strategy.

For NGINX based webservers, you may also need to adapt configuration. The changelogs of
TYPO3 will contain upgrade instructions, like in
:ref:`Deprecation: #87889 - TYPO3 backend entry point script deprecated <changelog:deprecation-87889-1705928143>`
