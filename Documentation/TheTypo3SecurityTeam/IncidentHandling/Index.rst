.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Incident handling
^^^^^^^^^^^^^^^^^

The next chapter provides detailed information about the differences
between the TYPO3 core system and TYPO3 extensions.


TYPO3 core system
"""""""""""""""""

If the TYPO3 Security Team gains knowledge about a security issue in
the TYPO3 core system, they work closely together with the developers
of the appropriate component of the system, after verifying the
problem. A fix for the vulnerability will be developed, carefully
tested and reviewed. Together with a public security bulletin, a TYPO3
core update will be released. Please see next chapter for further
details about TYPO3 versions and security bulletins.


TYPO3 extensions
""""""""""""""""

When the TYPO3 Security Team receives a report of a security issue in
an extension, the issue will be checked in the first stage. If a
security problem can be confirmed, the Security Team tries to get in
touch with the extension developer and requests a fix. Then one of the
following situations usually occurs:

- the developer acknowledges the security vulnerability and delivers a
  fix

- the developer acknowledges the security vulnerability but does not
  provide a fix

- the developer refuses to produce a security fix (e.g. because he does
  not maintain the extension anymore)

- the developer cannot be contacted or does not react

In the case where the extension author fails to provide a security fix
in an appropriate time frame (see below), all affected versions of the
extension will be removed from the TYPO3 Extension Repository (TER)
and a security bulletin will be published (see below), recommending to
deinstall the extension.

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
frames can be found in the official TYPO3 Extension Security Policy at
`http://typo3.org/teams/security/extension-security-policy/
<http://typo3.org/teams/security/extension-security-policy/>`_

