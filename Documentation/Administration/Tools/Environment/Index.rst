:navigation-title: Environment

..  include:: /Includes.rst.txt
..  _admin-tools-environment:

=========================
Environment (Admin Tools)
=========================

Only available if :composer:`typo3/cms-install` is installed.

The backend module :guilabel:`Admin Tools > Maintenance` contains tools
for system maintainers to get details about the server environment, such as PHP and database
versions, directory status, mail setup and image processing.

..  _environment-overview:

Environment overview
====================

This tool displays important details about the environment
your TYPO3 installation is running in. You can see which
database is being used. You can also see information like the operating
system, PHP version and application context.

..  _environment-status:

Environment status
==================

This tool tests if all suggested PHP extensions are installed and if
constraints like "Maximum PHP script execution" are set to recommended
values.

..  _environment-directory-status:

Directory status
================

..  figure:: /Images/ManualScreenshots/AdminTools/DirectoryStatus.png
    :alt: Output of the directory status with missing writing permissions for folder public

    You can use the button "Try to fix file and folder permissions"

This tool checks file system permissions and tries to fix them, if possible.
On Apache web servers the tool can also create the recommended :file:`.htaccess`
files for you.

If you are upgrading and already have a custom :file:`.htaccess` file, try to
:ref:`_maintain-htaccess`.

For NGINX based webservers, you may also need to update your configuration during
upgrades. The TYPO3 changelogs will contain upgrade instructions, like in
:ref:`Deprecation: #87889 - TYPO3 backend entry point script deprecated <changelog:deprecation-87889-1705928143>`.

For general NGINX configuration, see chapter
`NGINX web server configuration <https://docs.typo3.org/permalink/t3coreapi:system-requirements-nginx>`_.

..  _maintain-htaccess:

Verify webserver configuration (.htaccess)
------------------------------------------

After an update, the :file:`.htaccess` file may need to be modified for the latest TYPO3
major version (for Apache webservers), :ref:`see details on .htaccess <htaccess>`.

Compare the file :file:`vendor/typo3/cms-install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
(or `.htaccess <https://github.com/TYPO3/typo3/blob/main/typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles/root-htaccess>`__)
with your project's :file:`.htaccess` file and add new rules accordingly. If you haven't
edited the file, copy it over to your project to ensure that you are using the most recent version.

Your project's :file:`.htaccess` file should be under version control and part of your
deployment strategy.

..  _environment-php-info:

PHP info tool
=============

Outputs complete `phpinfo <https://www.php.net/manual/en/function.phpinfo.php>`_
- detailed information about PHP's configuration.

..  _environment-test-mail-setup:

Test mail setup
===============

Use this tool to send a test email from the TYPO3 backend to an email
address of your choice. If exceptions are raised when the email is sent, you will
also see the error message here.

This tool is helpful when trying to debug errors raised when an email is sent or when fixing
`MAIL settings <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-mail>`_.

..  _environment-test-image-processing:

Image processing test tool
==========================

This tool lets you compare the output of various image processing operations
with expected image output.

It can be helpful when debugging image generation errors and improving
the `GFX - graphics configuration settings <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-gfx>`_.
