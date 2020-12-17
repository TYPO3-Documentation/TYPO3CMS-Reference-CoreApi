.. include:: /Includes.rst.txt
.. index::
   Security guidelines; Content security policy
   Content security policy
   Cross-site scripting; Content security policy
   see: CSP; Content security policy
   CSP
.. highlight:: apacheconf
.. _security-content-security-policy:

=======================
Content security policy
=======================

Content security policy (CSP_) is an added layer of security that helps
to detect and mitigate certain types of attacks, including cross-site
scripting (XSS) and data injection attacks. These attacks are used for
everything from data theft to site defacement to the distribution of malware.

According to TYPO3-PSA-2019-010_ authenticated users - but not having
administrator privileges - are allowed to upload files to their granted
file mounts (e.g. `fileadmin/` in most cases). This also includes the
possibility to upload potential malicious code in HTML or SVG files
(using JavaScript, injecting cross-site scripting vulnerabilities).

To mitigate these potential scenarios it is advised to either
deny uploading files as described in TYPO3-PSA-2019-010_ (which might be
impractical for some sites) or add content security policy headers for
these directories - basically all public available base directories of
file storages (`sys_file_storage`).

The following example sends a corresponding CSP_ header for any file
accessed via https://example.org/fileadmin/...::

   # placed in fileadmin/.htaccess on Apache 2.x webserver
   <IfModule mod_headers.c>
     Header set Content-Security-Policy "default-src 'self'; script-src 'none'; style-src 'none'; object-src 'none';"
   </IfModule>

CSP rules can be verified with a CSP-Evaluator_

.. _CSP: https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
.. _TYPO3-PSA-2019-010: https://typo3.org/security/advisory/typo3-psa-2019-010
.. _CSP-Evaluator: https://csp-evaluator.withgoogle.com/
