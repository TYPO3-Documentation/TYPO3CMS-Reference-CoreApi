.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _reports-logs:

Reports and Logs
^^^^^^^^^^^^^^^^

Two backend modules in TYPO3 CMS require special attention: "Reports"
and "Logs":

The Reports module groups several system reports and gives you a quick
overview about important system statuses and site parameters. From a
security perspective, the section "Security" should be checked
regularly: it provides information about the administrator user
account, encryption key, file deny pattern, Install Tool and more.

The second important module is the Logs module, which lists system log
entries. The logging of some events depends on the specific
configuration but in general every backend user login/logout, failed
login attempt, etc. appears here. It is recommended to check for
security-related entries (column "Errors").

The information shown in these (and other) modules are senseless of
course, in cases where a compromised system was manipulated in the way
that incorrect details pretend that the system status is OK.

