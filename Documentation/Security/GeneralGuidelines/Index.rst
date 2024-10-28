.. include:: /Includes.rst.txt
.. index:: ! Security guidelines
.. _security-general-guidelines:

==================
General guidelines
==================

The recommendations in this chapter apply for all roles: system
administrators, TYPO3 integrators, editors and strictly speaking even
for (frontend) users.

.. index:: pair: Security guidelines; passwords
.. _security-secure-passwords:

Secure passwords
================

It is critical that every user is using secure passwords to
authenticate themselves at systems like TYPO3. Below are rules that
should be implemented in a password policy:

#. Ensure that the passwords you use have a minimum length of 8 or more
   characters.

#. Passwords should have a mix of upper and lower case letters, numbers
   and special characters.

#. Passwords should not be made up of personal information such as names,
   nick names, pet's names, birthdays, anniversaries, etc.

#. Passwords should not be made out of common words that can be found in
   dictionaries.

#. Do not store passwords on Post-it notes, under your desk cover, in
   your wallet, unencrypted on USB sticks or somewhere else.

#. Always use a different password for different logins! Never use the
   same password for your e-mail account, the TYPO3 backend, an online
   forum and so on.

#. Change your passwords in regular intervals but not too often (this
   would make remembering the correct password too difficult) and avoid
   to re-use the last 10 passwords.

#. Do not use the "stay logged in" feature on websites and do not store
   passwords in applications like FTP clients. Enter the password
   manually every time you log in.

A good rule for a secure password would be that a search engine such
as Google should deliver no results if you would search for it. Please
note: do not determine your passwords by this idea – this is an
example only how cryptic a password should be.

Another rule is that you should not choose a password that is too
strong either. This sounds self-contradictory but most people will
write down a password that is too difficult to remember – and this is
against the rules listed above.

In a perfect world you should use "trusted" computers, only. Public
computers in libraries, internet cafés, and sometimes even computers
of work colleagues and friends can be manipulated (with or without the
knowledge of the owner) and log your keyboard input.

..  tip::
    Since TYPO3 v12.0 password policies can be configured in backend and/or
    frontend context. Have a look into the chapter :ref:`password-policies`.


.. _security-update-operating-system:
.. _security-update-browser:

Operating System and Browser Version
====================================

Make sure that you are using up-to-date software versions of your
browser and that you have installed the latest updates for your
operating system (such as Microsoft Windows, Mac OS X or Linux). Check
for software updates regularly and install security patches
immediately or at least as soon as possible.

It is also recommended to use appropriate tools for detecting viruses,
Trojans, keyloggers, rootkits and other "malware".


.. _security-communication:

Communication
=============

A good communication between several roles is essential to clarify
responsibilities and to coordinate the next steps when updates are
required, an attacked site needs to be restored or other security-
related actions need to be done as soon as possible.

A central point of contact, for example a person or a team responsible
for coordinating these actions, is generally a good idea. This also
lets others (e.g. integrators, editors, end-users) know, to whom they
can report issues.



.. _security-react-quickly:

React Quickly
=============

TYPO3 is open source software as well as all TYPO3 extensions
published in the TYPO3 Extension Repository (TER). This means,
everyone can download and investigate the code base. From a security
perspective, this usually improves the software, simply because more
people review the code, not only a few Core developers. Currently,
there are hundreds of developers actively involved in the TYPO3
community and if someone discovers and reports a security issue,
he/she will be honored by being credited in the appropriate security
bulletin.

The open source concept also implies that everyone can compare the old
version with the new version of the software after a vulnerability
became public. This may give an insight to anyone who has programming
knowledge, how to exploit the vulnerability and therefore it is
understandable how important it is, to react quickly and fix the issue
before someone else compromises it. In other words, it is not enough
to receive and read the security bulletins, it is also essential to
react as soon as possible and to update the software or deinstall the
affected component.

The security bulletins may also include specific advice such as
configuration changes or similar. Check your individual TYPO3 instance
and follow these recommendations.

.. index:: pair: Security guidelines; TYPO3 update
.. _security-updating-typo3:

Keep the TYPO3 Core up-to-date
==============================

As described in :ref:`TYPO3 versions <security-typo3-versions>` chapter, a
new version of TYPO3 can either be a major update (e.g. from version 10.x.x to
version 11.x.x), a minor update (e.g. from version 11.4.x to version
11.5.x) or a maintenance/bugfix/security release (e.g. from version
11.5.11 to 11.5.12).

In most cases, a maintenance/bugfix/security update is a no-brainer,
see chapter ::ref:`Patch/Bugfix updates <t3coreapi:minor>`
for further details.

When you extract the archive file of new TYPO3 sources into the
existing install directory (e.g. the web root of your web server) and
update the symbolic links, pointing to the directory of the new version,
do not forget to **delete** the old and possibly insecure TYPO3 Core
version. Failing doing this creates the risk of leaving the source code
of the previous TYPO3 version on the system and as a consequence, the
insecure code may still be accessible and a security vulnerability
possibly exploitable.

Another option is to store the extracted TYPO3 sources outside of the
web root directory (so they are not accessible via web requests) as
a general rule and use symbolic links inside the web root to point to
the correct and secure TYPO3 version.

.. index:: pair: Security guidelines; Extensions update
.. _security-updating-extensions:

Keep TYPO3 Extensions Up-to-date
================================

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

..  todo: Update this to include Composer

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

.. code-block:: none
   :caption: Remove old extensions, dont rename

    typo3conf/ext/insecure_extension.bak
    typo3conf/ext/insecure_extension.delete_me
    typo3conf/ext/insecure_extension-1.2.3
    ...

The risk of exploiting a vulnerability is minimal, because the source
code of the extension is not loaded by TYPO3, but it depends on the type
of vulnerability of course.

The advice is to move the directory of the old version outside of the
web root directory, so the insecure extension code is not accessible.


.. index:: pair: Security guidelines; Staging servers
.. _security-staging-servers:

Use staging servers for developments and tests
==============================================

During the development phase of a project and also after the launch of
a TYPO3 site as ongoing maintenance work, it is often required to test
if new or updated extensions, `PHP`, `TypoScript` or other code meets the
requirements.

A website that is already "live" and publicly accessible should not be
used for these purposes. New developments and tests should be done on
so called "staging servers" which are used as a temporary stage and
could be messed up without an impact on the "live" site. Only
relevant/required, tested and reviewed clean code should then be
implemented on the production site.

This is not security-related on the first view but "tests" are often
grossly negligent implemented, without security aspects in mind.
Staging servers also help keeping the production sites slim and clean
and reduce maintenance work (e.g. updating extensions which are not in
use).
