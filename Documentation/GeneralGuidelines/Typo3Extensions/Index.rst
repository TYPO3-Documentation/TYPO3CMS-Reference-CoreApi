.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _updating-extensions:

Keep TYPO3 extensions up-to-date
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Do not rely on publicly released security announcements only. Reading
the official security bulletins and updating TYPO3 extensions which
are listed in the bulletins is an essential task but not sufficient to
have a "secure" system.

Extension developers sometimes fix security issues in their extensions
without notifying the Security Team (and maybe without mentioning it
in the ChangeLog or in the upload comments). This is not the
recommended way, but possible. Therefore updating extensions whenever
a new version is published is a good idea in general – at least
investigating/reviewing the changes and assessing if an update is
required.

Also keep in mind that attackers often scan for system components that
contain known security vulnerabilities to detect points of attack.
These "components" can be specific software packages on a system
level, scripts running on the web server but also specific TYPO3
versions or TYPO3 extensions.

The recommended way to update TYPO3 extensions is to use TYPO3's
internal Extension Manager (EM). The EM takes care of the download of
the extension source code, extracts the archive and stores the files in
the correct place, overwriting an existing old version by default. This
ensures, the source code containing a possible security vulnerability
will be removed from server when a new version of an extension is
installed.

When a system administrator decides to create a copy of the directory of
an existing insecure extension, before installing the new version, he/she
often introduces the risk of leaving the (insecure) copy on the web
server. For example:

::

    typo3conf/ext/insecure_extension.bak
    typo3conf/ext/insecure_extension.delete_me
    typo3conf/ext/insecure_extension-1.2.3
    ...

The risk of exploiting a vulnerability is minimal, because the source
code of the extension is not loaded by TYPO3, but it depends on the type
of vulnerability of course.

The advice is to move the directory of the old version outside of the
web root directory, so the insecure extension code is not accessible.

