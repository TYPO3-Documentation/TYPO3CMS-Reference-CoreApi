.. include:: /Includes.rst.txt
.. index:: Hacked site; Repair
.. _security-repair-restore:

==============
Repair/restore
==============

When you know what the problem was and how the attacker gained access
to your system, double check if there are no other security
vulnerabilities. Then, you may want to either repair the
infected/modified/deleted files or choose to make a full restore from
a backup (you need to make sure that you are using a backup that has
been made before the attack). Using a full restore from backup has the
advantage, that the website is returned to a state where the data has
been intact. Fixing only individual files bears the risk that some
malicious code may be overlooked.

Again: it is not enough to fix the files or restore the website from a
backup. You need to locate the entry point that the attacker has used
to gain access to your system. If this is not found (and fixed!), it
will be only a matter of time, until the website is hacked again.

So called "backdoors" are another important thing you should keep in
mind: if an attacker had access to your site, it is possible and common
practise that it implemented a way to gain unauthorized access to
the system at a later time (again). Even if the original security
vulnerability has been fixed (entry point secured), all passwords
changed, etc., such a backdoor could be as simple as a new backend user
account with an unsuspicious user name (and maybe administrator
privileges) or a PHP file hidden somewhere deep in the file system,
which contains some cryptic code to obscure its malicious purpose.

Assuming all "infected" files have been cleaned and the vulnerability
has been fixed, make sure to take corrective actions to prevent
further attacks. This could be a combination of software updates,
changes in access rights, firewall settings, policies for log file
analysis, the implementation of an intrusion detection system, etc. A
system that has been compromised once should be carefully monitored in
the following months for any signs of new attacks.

