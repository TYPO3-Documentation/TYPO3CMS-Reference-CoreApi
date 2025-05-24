:navigation-title: HTTPS & encryption

..  include:: /Includes.rst.txt
..  index:: pair: Security guidelines; Encryption
..  index:: pair: Security guidelines; Transport layer security
..  _security-encrypted-client-server-connection:

===================================
Use HTTPS and encrypted connections
===================================

Why your TYPO3 site should always use HTTPS — and how to protect other
data in transit.

..  _security-backend-encryption:

Encrypt TYPO3 backend access
============================

A risk of unencrypted client/server communication is that an attacker
could eavesdrop the data transmission and "sniff" sensitive
information such as access details. Unauthorized access to the TYPO3
backend, especially with an administrator user account, has a
significant impact on the security of your website. It is clear that
the use of `TLS` for the backend of TYPO3 improves the security.

TYPO3 supports a `TLS` encrypted backend and offers some specific
configuration options for this purpose, see configuration option
:ref:`lockSSL <security-global-typo3-options-lockSSL>`.

..  _security-frontend-encryption:

Encrypt website frontend with HTTPS
===================================

`Transport Layer Security (TLS) <https://en.wikipedia.org/wiki/Transport_Layer_Security>`_
is the standard technology for encrypting communication between a web browser
and a server. It ensures that data (like login details or form entries) stays
private and cannot be altered or intercepted.

TLS uses certificates to verify the identity of a website. These certificates
contain details such as the domain name and organization behind the site.

Whenever sensitive data is exchanged between a visitor and your TYPO3 website,
you should use an encrypted connection — typically by using `https://` instead
of `http://`.

For online shops or payment gateways, encryption is often required by card issuers
or financial institutions. Always check the security policies of your payment provider.

..  _security-data-classification:

Classify and protect sensitive data
===================================

Data sensitivity depends on the type of information being handled. Examples of
"sensitive" data include:

-   Login credentials
-   Personal details (e.g., names, addresses)
-   Medical and financial records

Classifying your data helps determine how it must be stored, transmitted, and protected.
Use a model that categorizes data by disclosure risk and legal or organizational impact.

The secure and maybe encrypted storage of sensitive data should also
be considered.

The safest policy: do not store or transmit sensitive data unless absolutely necessary.

..  _security-ftp-alternatives:

Avoid FTP — use secure alternatives
===================================

Encryption should also be used for server access methods beyond the browser.

**Never use plain FTP.** Instead, use encrypted alternatives such as:

-   `SFTP` (SSH File Transfer Protocol)
-   `FTPS` (FTP Secure)
-   `SSH` (Secure Shell)

These protocols encrypt credentials and data during transfer, reducing the risk
of interception or unauthorized access.
