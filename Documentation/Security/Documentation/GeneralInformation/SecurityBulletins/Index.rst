.. include:: ../../Includes.txt


.. _security-bulletins:

Security bulletins
^^^^^^^^^^^^^^^^^^

When security updates for TYPO3 or an extension become available, they
will be announced on the "TYPO3 Announce" mailing list, as described
above, but also published with much more specific details on the
official TYPO3 Security Team website at
`https://typo3.org/help/security-advisories/
<https://typo3.org/help/security-advisories/>`_

Security bulletins for the TYPO3 core are separated from security
bulletins for TYPO3 extensions. Every bulletin has a unique advisory
identifier such as TYPO3-CORE-SA-yyyy-nnn (for bulletins applying to
the TYPO3 core) and TYPO3-EXT-SA-yyyy-nnn (for bulletins applying to
TYPO3 extensions), where yyyy stands for the appropriate year of
publication and nnn for a consecutively increasing number.

The bulletins contain information about the versions of TYPO3 or
versions of the extension that are affected and the type of security
issue (e.g. information disclosure, cross-site scripting, etc.). The
bulletin does not contain an exploit or a description on how to
(ab)use the security issue.

The severity is an indication on how important the issue is:


.. ### BEGIN~OF~SIMPLE~TABLE ###

.. Note: The exact "styling" of the following table is important.
   There may be no text in the column margin.

============   ======================================================
Severity       Meaning
============   ======================================================
**Critical**   This is a critical security issue and action should be
               taken immediately (on the day of the release).
**High**       This is an important security issue and action should
               be taken as soon as possible.
**Medium**     Your website may be affected by this issue and you
               should consider taking action as soon as feasible.
**Low**        There is a good chance that your site is not affected
               by this issue or that it can be exploited only in
               special circumstances. However, you should check
               whether your site is at risk and consider necessary
               action.
============   ======================================================


.. ###### END~OF~SIMPLE~TABLE ######


For TYPO3 extensions, there are two types of security bulletins:

- Individual Security Bulletin: bulletins issued for extensions that
  have a high number of downloads and are used in many projects.

- Collective Security Bulletins: updates for extensions with a relative
  small number of downloads are published in a collective bulletin. Such
  a bulletin may contain information about 10 or even more extensions.

For some critical security issues the TYPO3 Security Team may decide
to pre-announce a security bulletin on the "TYPO3 Announce" mailing
list. This is to inform system administrators about the date and time
of an upcoming important bulletin, so that they can schedule the
update.

Security issues in the TYPO3 core which are only exploitable by users
with administrator privileges (including system components that are
accessible by administrators only, such as the Install Tool) are
treated as normal software "bugs" and are fixed as part of the
standard core review process. This implies that the development of the
fix including the review and deployment is publicly visible and can be
monitored by everyone.


Public Service Announcements
""""""""""""""""""""""""""""

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


Common Vulnerability Scoring System (CVSS)
""""""""""""""""""""""""""""""""""""""""""

Since 2010 the TYPO3 Security Team also publishes a CVSS rating with
every security bulletin. CVSS ("Common Vulnerability Scoring System" is
a free and open industry standard for communicating the characteristics
and impacts of vulnerabilities in Information Technology. It enables
analysts to understand and properly communicate disclosed vulnerabilities
and allows responsible personnel to prioritize risks. Further details
about CVSS are available at `http://www.first.org/cvss/cvss-guide.html
<http://www.first.org/cvss/cvss-guide.html>`_

