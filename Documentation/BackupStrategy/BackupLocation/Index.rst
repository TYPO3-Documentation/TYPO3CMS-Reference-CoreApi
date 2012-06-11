

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


Backup location
^^^^^^^^^^^^^^^

Backups are typically created on the same server as the TYPO3 instance
and often stored there as well. In this case, the backup files should
be copied to external systems to prevent data loss from a hardware
failure. If backups are only stored on the local system and an
attacker gains full control over the server, he might delete the
backup files. Protecting the external systems against any access from
the TYPO3 server is also highly recommended, so you should consider
"fetching" the backups from the TYPO3 system instead of "pushing" them
to the backup system.

When external systems are used they should be physically separated
from the production server in order to prevent data loss due to fire,
flooding, etc.

Please read the terms and conditions for your contract with the
hosting provider carefully. Typically the customer is responsible for
the backup, not the provider. Even if the provider offers a backup,
there may be no guarantee that the backup will be available. Therefore
it is good practice to transfer backups to external servers in regular
intervals.

In case you are also storing backups on the production server, make
sure that they are placed outside of the root directory of your
website and cannot be accessed with a browser. Otherwise everybody
could simply download your backups, including sensitive data, such as
passwords (not revealing the URL is not a sufficient measure from a
security perspective).

