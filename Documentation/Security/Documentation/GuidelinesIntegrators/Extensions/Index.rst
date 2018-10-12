.. include:: ../../Includes.txt


.. _extensions:

TYPO3 extensions
^^^^^^^^^^^^^^^^

As already mentioned above, most of the security issues have been
discovered in TYPO3 extensions, not in the TYPO3 core. Due to the fact
that everybody can publish an extension in the TYPO3 repository, you
never know how savvy and experienced the programmer is and how the
code was developed from a security perspective.

The following sections deal with extensions in general, the risks and
the basic countermeasures to address security related issues.


.. _extension-state:

Stable and reviewed extensions
""""""""""""""""""""""""""""""

Only a small percentage of the extensions available in the TER have
been reviewed by the TYPO3 Security team. This does not imply that
extensions without such an audit are insecure, but they probably have
not been checked for potential security issues by an independent 3rd
party (such as the TYPO3 Security Team).

The status of an extension ("alpha", "beta", "stable", etc.) should
also give you an indication in which state the developer claims the
extension is. However, this classification is an arbitrary setting by
the developer and may not reflect the real status and/or opinions of
independent parties.

Always keep in mind that an extension may not perform the
functionality that it pretends to do: an attacker could write an
extension that contains malicious code or functions and publish it
under a promising name. It is also possible that a well-known,
harmless extension will be used for an attack in the future by
introducing malicious code with an update. In a perfect world, every
updated version would be reviewed and checked, but it is
understandable that this approach is unlikely to be practical in most
installations.

Following the guidelines listed below would improve the level of
security, but the trade-off would be more effort in maintaining your
website and a delay of updating existing extensions (which would
possibly be against the "react quickly" paradigm described above).
Thus, it depends on the specific case and project, and the intention
of listing the points below is more to raise the awareness of possible
risks.

- Do not install extensions or versions marked as "alpha" or "obsolete"
  (the developer classified the code as a very early version, preview,
  prototype, proof-of-concept and/or as not maintained – nothing you
  should install on a production site).

- Be very careful when using extensions or versions marked as "beta"
  (according to the developer, this version of the extension is still in
  development, so it is unlikely that any security-related tests or
  reviews have been undertaken so far).

- Be careful with extensions and versions marked as "stable" (but not
  reviewed by the TYPO3 Security Team).

- Check every extension and extension update before you install it on a
  production site and review it in regards to security (see chapter "Use
  staging servers for developments and tests").


.. _extension-binaries:

Executable binaries shipped with extensions
"""""""""""""""""""""""""""""""""""""""""""

TYPO3 extensions (.t3x files) are packages, which may contain any kind
of data/files. This can not only be readable PHP or Javascript source
code, but also binary files, e.g. Unix/Linux ELF files or Microsoft
Windows .exe files (compiled executables).

Executing these files on a server is a security risk, because it can not
be verified what these files really do (unless they are
reverse-engineered or dissected likewise). Thus it is highly recommended
**not** to use any TYPO3 extensions, which contain executable binaries.
Binaries should only come from trusted and/or verified sources such as
the vendor of your operating system - which also ensures, these binaries
get updated in a timely manner, if a security vulnerability is
discovered in these components.


.. _extension-remove:

Remove unused extensions and other code
"""""""""""""""""""""""""""""""""""""""

TYPO3 CMS distinguishes between "imported" and "loaded" extensions.
Imported extensions exist in the system and are ready to be integrated
into TYPO3 but they are not installed yet. Loaded extensions are
available for being used (or are being used automatically, depending
on their nature), so they are "installed".

A dangerous and loaded extension is able to harm your system in
general because it becomes part of the system (functions are
integrated into the system at runtime). Even extensions which are not
loaded (but only "imported") include a kind of risk because their code
may contain malicious or vulnerable functions which in theory could be
used to attack the system.

As a general rule, it is highly recommended you remove all code from
the system that is not in use. This includes TYPO3 extensions, any
TypoScript (see below), PHP scripts as well as all other functional
components. In regards to TYPO3 extensions, you should remove unused
extensions from the system (not only unload/deinstall them). The
"Extension Manager" offers an appropriate function for this:
"Backup/Delete" - an administrator backend account is required.


.. _extension-lowlevel:

Low-level extensions
""""""""""""""""""""

So called "low-level" extensions provide "questionable" functionality
to a level below what a standard CMS would allow you to access. This
could be for example direct read/write access to the file system or
direct access to the database (see chapter "Guidelines for System
Administrators: Database access" above). If a TYPO3 integrator or a
backend user (e.g. an editor) depends on those extensions, it is most
likely that a misconfiguration of the system exists in general.

TYPO3 extensions like "phpMyAdmin", various file browser/manager
extensions, etc. may be a good choice for a development or test
environment but are definitely out of place at production sites.

Extensions that allow editors to include PHP code should be avoided,
too.


.. _extension-updates:

Check for extension updates regularly
"""""""""""""""""""""""""""""""""""""

The importance of the knowledge that security updates are available
has been discussed above (see chapter: "TYPO3 security-bulletins"). It
is also essential to know how to check for extension updates: the
"Extension Manager" (EM) is a TYPO3 CMS backend module accessible for
backend users with administrator privileges (section "ADMIN TOOLS").
A manual check for extension updates is available in this module.

The EM uses a cached version of the extension list from the TYPO3
Extension Repository (TER) to compare the extensions currently
installed and the latest versions available. Therefore, you should
retrieve an up-to-date version of the extension list from TER before
checking for updates.

If extension updates are available, they are listed together with a
short description of changes (the "upload comment" provided by the
extension developers) and you can download/install the updates if
desired. Please note that under certain circumstances, new versions
may behave differently and a test/review is sometimes useful,
depending on the nature and importance of your TYPO3 CMS instance.
Often a new version of an extension published by the developer is not
security-related.

Older versions of the EM mark insecure extensions by a red extension
title.

A scheduler task is available that lets you update the extension list
automatically and periodically (e.g. once a day). In combination with
the task "System Status Update (reports)", it is possible to get a
notification by email when extension updates are available.


.. _extension-security:
.. _rsaauth:
.. _saltedpasswords:


Security-related core extensions
""""""""""""""""""""""""""""""""

Besides the "Reports" module described above, the two system extensions
"rsaauth" and "saltedpasswords" increase the level of security of a
TYPO3 CMS instance. Both extensions are automatically activated for
new installations.

"RSA authentication" (rsaauth) adds encrypted authentication for
frontend and backend logins to TYPO3 CMS. This is a more secure solution
than plain text frontend authentication or superchallenged backend
authentication because rsaauth uses a one time generated public and
private key pair. The password is encrypted with a new public key each
time, before it is transferred over the network – and decrypted on the
server using a one time generated private key. The rsaauth extension
requires either an OpenSSL PHP module or the OpenSSL binary to be
available to TYPO3 CMS.

The second extension focuses on the storage of passwords: by using the
"Salted user password hashes" (saltedpasswords) extension, you get rid
of plain-text passwords or MD5 password hashes for user records in
TYPO3 CMS. Due to the fact that MD5 hashes should be considered as
cryptographically insecure, they are unsuitable for representing
passwords. Using rainbow tables is a widely spread practice these days
and plain-text passwords can be restored from MD5 hashes in minutes.
Salted hashes increase the complexity of this process drastically and
the efforts required to restore a password by using rainbow tables
exceed the benefit.

Another advantage of the saltedpasswords extension is that it
generates different hashes for the same password, if triggered
multiple times.

If you enable the extension on a system with existing users, the
passwords will automatically be converted when a user record is saved
(e.g. the next time the user logs in). TYPO3 CMS also offers several
solutions to update existing passwords of all users to encrypted
values; please see the documentation of the extension for further
details.


.. _extension-other:

Other security-related extensions
"""""""""""""""""""""""""""""""""

TYPO3 extensions which are not part of the core (and so are not
official system extensions) are out of scope of this document, due to
the fact that this Security Guide focuses on a TYPO3 standard setup.

However, there is a wide range of very useful TYPO3 extensions
available in the TYPO3 Extension Repository (TER) which increase the
level of security and/or support system administrators and TYPO3
integrators to monitor their TYPO3 installations, check for
security-related issues, access additional reports and be notified in
various ways.

Searching for relevant keywords such as "security", "monitoring" or a
specific technology (e.g. "intrusion detection") or a security threat
(e.g. "XSS", "SQL injection") or similar shows some results, which
could be reviewed and tested.

Please note that these extensions are often not developed/maintained
by TYPO3 core developers and the code quality may vary. Also, check
for extensions reviewed by the Security Team and the date of the last
update.

