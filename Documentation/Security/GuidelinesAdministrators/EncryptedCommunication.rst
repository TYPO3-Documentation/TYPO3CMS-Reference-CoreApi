.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; Encryption
.. _security-encrypted-client-server-connection:

=====================================
Encrypted Client/server Communication
=====================================


Data Classification
===================

It depends on the nature of the data but in general "sensitive"
information could be: user logins, passwords, user details (such as
names, addresses, contact details, etc.), email addresses and other
data which are not public. Medical, financial data (for example credit card
details, account numbers, access codes, etc.) and others, are
confidential by their nature and must not be transmitted unencrypted
at all.

In most cases, a data assessment should be undertaken to classify the
data according to several traits relating to use, legal requirements,
and value. The outcome of this assessment can be a categorization
based on a data classification model, which then defines how to
protect the data.

========================  ================  =========================  ===========================  ====================
 .. Comment (invisible)   Public            Public Restricted          Organization Confidential    Organization Secret
========================  ================  =========================  ===========================  ====================
**Type**                  non-sensitive     externally sensitive       internally sensitive         extremely sensitive
**Disclosure impact**     none              limited                    significant                  sever
**Access restrictions**   none              low (for example           high (for example public     very high
                                            username/ password)        /private key + geolocation)
**Data transport**        unencrypted       unencrypted but protected  encrypted                    highly encrypted
**Storage requirements**  none              unencrypted but protected  encrypted                    highly encrypted
========================  ================  =========================  ===========================  ====================

The secure and maybe encrypted storage of sensitive data should also
be considered.

The most secure first paradigm in most cases is: do neither transmit
nor store any sensitive data if not absolutely required.

.. index::
   pair: Security guidelines; Transport layer security
   pair: Security guidelines; SSL
   pair: Security guidelines; https
   Transport layer security
   see: TLS; Transport layer security
   TLS

Frontend
========

`Transport Layer Security (TLS) <https://de.wikipedia.org/wiki/Transport_Layer_Security>`_
is an industry standard and the current security technology for establishing an encrypted
link between a browser (client) and a web server. This protocol provides encrypted,
authenticated communications across the Internet and ensures that all
data passed between client and server remains private and integral. It
is based on a public/private key technology and uses certificates
which typically contain the domain name and details about the website
operator (for example company name, address, geographical location, etc.).
Recent discussions are questioning the organizational concept behind
SSL certificates and the "chain of trust", but the fact is that SSL is
the de facto standard today and still is considered secure from a
technical perspective.

Whenever sensitive data is transferred between a client (the visitor
of the website) and the server (TYPO3 website), a `TLS` encrypted
connection should be used. Most often his means the protocol `https`
is used instead of `http`.

When using payment gateways to process payments for online shops for
example, most financial institutions (for example credit card vendors)
require appropriate security actions. Check the policies of the
gateway operator and card issuers before you institute online payment
solutions.


Backend
=======

A risk of unencrypted client/server communication is that an attacker
could eavesdrop the data transmission and "sniff" sensitive
information such as access details. Unauthorized access to the `TYPO3`:pn:
backend, especially with an administrator user account, has a
significant impact on the security of your website. It is clear that
the use of `TLS` for the backend of TYPO3 improves the security.

`TYPO3`:pn: supports a `TLS` encrypted backend and offers some specific
configuration options for this purpose, see configuration option
:ref:`lockSSL <security-global-typo3-options-lockSSL>`.

.. index:: pair: Security guidelines; FTP

Drop FTP
========

An encrypted communication between client and server for further
services than the TYPO3 frontend and backend should be considered,
too. For example, it is highly recommended to use encrypted services
such as `SSH` (secure shell), `SFTP` (SSH file transfer protocol) or `FTPS`
(FTP-Secure) instead of `FTP`, where data is transferred unencrypted.

