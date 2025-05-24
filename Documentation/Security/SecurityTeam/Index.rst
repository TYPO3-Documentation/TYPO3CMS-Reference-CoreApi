:navigation-title: Security Team

..  include:: /Includes.rst.txt
..  index:: Security team
..  _security-team:

====================================
Working with the TYPO3 Security Team
====================================

You can find details about the TYPO3 Security Team at
https://typo3.org/community/teams/security/.

You can contact the TYPO3 Security Team at `security@typo3.org <mailto:security@typo3.org>`_ .

TYPO3 Core security updates, extension security updates, and unmaintained
insecure extensions are announced in formal
`TYPO3 Security Bulletins <https://typo3.org/help/security-advisories>`_.


..  index:: Security; Reporting
..  _security-team-contact:

Reporting a security issue
==========================

If you find a security issue in the TYPO3 Core system or in a TYPO3
extension (even if it is your own development), please report it to
the `TYPO3 Security Team <mailto:security@typo3.org>`_ – the Security Team only.
Do not disclose the issue in public (for example in mailing lists, forums, on Twitter,
your website or any 3rd party website).

The team strives to respond to all reports within
2 working days, but please allow a reasonable amount of
time to assess the issue and get back to you with an answer. If you
suspect that your report has been overlooked, feel free to submit a
reminder a few days after your initial submission.

..  index::
    Security; Extension review
    Extension review

..  _security-extension-review:

Extension review
================

The TYPO3 Security Team does not perform individual reviews or audits of TYPO3 extensions.

If you require a professional security audit of your extension or website,
consider engaging an experienced TYPO3 agency. Official TYPO3 Solution Partners
often provide such services, including:

-   Security audits
-   Code and architecture reviews
-   Consulting on best practices

You can find a list of official TYPO3 partners at:
https://typo3.com/partners

Additionally, some third-party providers also offer TYPO3 security services.
Make sure to evaluate their experience and qualifications carefully.

..  index:: Security; Incident handling
..  _security-incident-handling:

Incident handling
=================

This section provides detailed information about the differences between
the TYPO3 Core system and TYPO3 extensions and how the TYPO3 Security
Team deals with security issues of those.

..  _security-incident-handling-core:

Security issues in the TYPO3 Core
---------------------------------

If the TYPO3 Security Team gains knowledge about a security issue in
the TYPO3 Core system, they work closely together with the developers
of the appropriate component of the system, after verifying the
problem. A fix for the vulnerability will be developed, carefully
tested and reviewed. Together with a public security bulletin, a TYPO3
Core update will be released. Please see next chapter for further
details about TYPO3 versions and security bulletins.

..  _security-incident-handling-extensions:

Security issues in TYPO3 extensions
-----------------------------------

When the TYPO3 Security Team receives a report of a security issue in
an extension, the issue will be checked in the first stage. If a
security problem can be confirmed, the Security Team tries to get in
touch with the extension developer and requests a fix. Then one of the
following situations usually occurs:

*   the developer acknowledges the security vulnerability and delivers a
    fix
*   the developer acknowledges the security vulnerability but does not
    provide a fix
*   the developer refuses to produce a security fix (e.g. because he does
    not maintain the extension anymore)
*   the developer cannot be contacted or does not react

In the case where the extension author fails to provide a security fix
in an appropriate time frame (see below), all affected versions of the
extension will be removed from the TYPO3 Extension Repository (TER)
and a security bulletin will be published (see below), recommending to
uninstall the extension.

If the developer provides the TYPO3 Security Team with an updated
version of the extension, the team reviews the fix and checks if the
problem has been solved. The Security Teams also prepares a security
bulletin and coordinates the release date of the new extension version
with the publication date of the bulletin.

Extension developers must not upload the new version of the extension
before they received the go-ahead from the Security Team.

If you discover a security problem in your own extension, please
follow this procedure as well and coordinate the release of the fixed
version with the TYPO3 Security Team.

Further details about the handling of security incidents and time
frames can be found in the official
`TYPO3 Extension Security Policy
<https://typo3.org/community/teams/security/extension-security-policy/>`_
