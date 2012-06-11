

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


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

