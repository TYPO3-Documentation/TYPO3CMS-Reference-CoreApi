:navigation-title: Versions & Updates

..  include:: /Includes.rst.txt
..  _security-general-information:

==========================================
TYPO3 version support and security updates
==========================================

TYPO3 evolves through regular releases, including Long Term Support (LTS) versions
and Sprint Releases. This page explains which versions are supported, how security
updates are announced, and what to expect from TYPO3's Core and extension maintenance.
It also shows how to stay informed and react quickly to vulnerabilities.

..  contents:: Table of contents

..  index::
   pair: Security guidelines; TYPO3 versions
   Security guidelines; Long term support
   Long term support
   see: LTS; Long term support
   LTS
..  _security-typo3-versions:

TYPO3 versions and lifecycle
============================

TYPO3 is offered in Long Term Support (LTS) and Sprint Release versions.

The first versions of each branch are Sprint Release versions. A Sprint Release
version only receives support until the next Sprint Release got published. For
example, TYPO3 v12.0.0 was the first Sprint Release of the v12 branch and its
support ended when TYPO3 v12.1.0 got released.

An LTS version is planned to be created every 18 months. LTS versions are created
from a branch in order to finalize it: Prior to reaching LTS status, a number of
Sprint Releases has been created from that branch and the release of an LTS version
marks the point after which no new features will be added to this branch. LTS
versions get full support (bug fixes and security fixes) for at least three years.
TYPO3 version 11 (v11) and v12 are such LTS versions.

The minor-versions are skipped in the official
naming. 13 LTS is version v13.4 internally and 12 LTS is v12.4. Versions inside
a major-version have minor-versions as usual (v13.0, v13.1, ...) until at some
point the branch receives LTS status.

Support and security fixes are provided for the current as well as the
preceding LTS release. For example, when TYPO3 v13 is the current LTS release,
TYPO3 v12 is still actively supported, including security updates.

For users of v12 an update to v13 is recommended. All versions below TYPO3 v12 are
outdated and the regular support of these versions has ended, including security updates.
Users of these versions are strongly encouraged to update their systems
as soon as possible.

In cases where users cannot yet upgrade to a supported version, the TYPO3 GmbH is offering
an Extended Long Term Support (ELTS) service for up to three years after the regular support has ended.
Subscribers to the ELTS plans receive security and compatibility updates.

Information about ELTS is available at https://typo3.com/services/extended-support-elts

LTS and Sprint Releases offer new features and often a modified
database structure. Also the visual appearance and handling of the
backend may be changed and appropriate training for editors may be
required. The content rendering may change, so that updates in
TypoScript, templates or CSS code may be necessary. With LTS and
Sprint Releases also the system requirements (for example PHP or MySQL
version) may change. For a patch level release (i.e.
changing from release v12.4.0 to v12.4.1) the database structure and
backend will usually not change and an update will only require the
new version of the source code.

List of TYPO3 LTS releases:

*   v9 (9.5 ELTS): No free bugfix/security update. Extended long-term support
    can be ordered at https://typo3.com/services/extended-support-elts
*   v10 (10.4 ELTS): No free bugfix/security update. Extended long-term support
    can be ordered at https://typo3.com/services/extended-support-elts
*   v11 (11.5 ELTS): No free bugfix/security update. Extended long-term support
    can be ordered at https://typo3.com/services/extended-support-elts
*   v12 (12.4 LTS): Versions 12.0 through 12.3 do not receive security
    updates any longer
*   v13 (13.4 LTS): Versions 13.0 through 13.3 do not receive security
    updates any longer


..  _security-difference-core-extensions:

Difference between Core and extensions
======================================

The TYPO3 base system is called the Core. The functionality of the
Core can be expanded, using extensions. A small, selected number of
extensions (the system extensions) are being distributed as part of
the TYPO3 Core. The Core and its system extensions are being developed
by a relatively small team (40-50 people), consisting of experienced
and skilled developers. All code being submitted to the Core is
reviewed for quality by other Core Team members.

Currently there are more than 5500 extensions available in the TYPO3
Extension Repository (TER), written by some 2000 individual
programmers. Since everybody can submit extensions to the TER, the
code quality varies greatly. Some extensions show a very high level of
code quality, while others have been written by amateurs. Most of the
known security issues in TYPO3 have been found in these extensions,
which are not part of the Core system.


..  _security-announcement-updates:

Announcement of updates and security fixes
==========================================

Information about new TYPO3 releases as well as security bulletins are
being announced on the "TYPO3 Announce" mailing list. Every system
administrator who hosts one or more TYPO3 instances, and every TYPO3
integrator who is responsible for a TYPO3 project should subscribe to
this mailing list, as it contains important information. You can
subscribe at https://lists.typo3.org/cgi-bin/mailman/listinfo/typo3-announce.

This is a read-only mailing list, which means that you cannot reply to
a message or post your own messages. The announce list typically does
not distribute more than 3 or 4 mails per month. However it is highly
recommended to carefully read every message that arrives, because they
contain important information about TYPO3 releases and security
bulletins.

Other communication channels such as https://news.typo3.org/, a RSS feed,
an official Twitter account `@typo3\_security <https://twitter.com/typo3_security>`_  etc.
can be used additionally to stay up-to-date on security advisories.

..  index::
   Security guidelines; Security bulletins
   Security bulletins
..  _security-bulletins:

Security bulletins
==================

When security updates for TYPO3 or an extension become available, they
will be announced on the "TYPO3 Announce" mailing list, as described
above, but also published with much more specific details on the
official TYPO3 Security Team website at https://typo3.org/help/security-advisories/.

Security bulletins for the TYPO3 Core  are separated from security
bulletins for TYPO3 extensions. Every bulletin has a unique advisory
identifier such as TYPO3-CORE-SA-yyyy-nnn (for bulletins applying to
the TYPO3 Core ) and TYPO3-EXT-SA-yyyy-nnn (for bulletins applying to
TYPO3 extensions), where yyyy stands for the appropriate year of
publication and nnn for a consecutively increasing number.

The bulletins contain information about the versions of TYPO3 or
versions of the extension that are affected and the type of security
issue (e.g. information disclosure, cross-site scripting, etc.). The
bulletin does not contain an exploit or a description on how to
(ab)use the security issue.

For some critical security issues the TYPO3 Security Team may decide
to pre-announce a security bulletin on the "TYPO3 Announce" mailing
list. This is to inform system administrators about the date and time
of an upcoming important bulletin, so that they can schedule the
update.

Security issues in the TYPO3 Core  which are only exploitable by users
with administrator privileges (including system components that are
accessible by administrators only, such as the Install Tool) are
treated as normal software "bugs" and are fixed as part of the
standard Core review process. This implies that the development of the
fix including the review and deployment is publicly visible and can be
monitored by everyone.

..  index::
   Security bulletins; Public service announcements
   Public service announcements
   see: PSA; Public service announcements
   PSA

..  _security-bulletins-psa:

Public service announcements
----------------------------

Important security related information regarding TYPO3 products or the
typo3.org infrastructure are published as so called "Public Service
Announcements" (PSA). Unlike other advisories, a PSA is usually not
accompanied by a software release, but still contain information about
how to mitigate a security related issue.

Topics of these advisories include security issues in third party
software like such as Apache, Nginx, MySQL, PHP, etc. that are related
to TYPO3 products, possible security related misconfigurations in third
party software, possible misconfigurations in TYPO3 products, security
related information about the server infrastructure of typo3.org and
other important recommendations how to securely use TYPO3 products.

..  index::
   Security bulletins; Common vulnerability scoring system
   Common vulnerability scoring system
   see: CVSS; Common vulnerability scoring system
   CVSS

..  _security-bulletins-cvss:

Common vulnerability scoring system (CVSS)
------------------------------------------

Since 2010 the TYPO3 Security Team also publishes a CVSS rating with
every security bulletin. CVSS ("Common Vulnerability Scoring System" is
a free and open industry standard for communicating the characteristics
and impacts of vulnerabilities in Information Technology. It enables
analysts to understand and properly communicate disclosed vulnerabilities
and allows responsible personnel to prioritize risks. Further details
about CVSS are available at https://www.first.org/cvss/user-guide
