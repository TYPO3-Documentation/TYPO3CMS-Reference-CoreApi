

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Other services
^^^^^^^^^^^^^^

System administrators should keep in mind that every "untrusted"
script (e.g. PHP, perl, python script) or executable file inside the
web server's document root is a security risk. By a correct and secure
configuration, the internal security mechanisms of TYPO3 ensure that
the CMS does not allow editors and other unprivileged users to place
such code through the system (see chapter "Global TYPO3 configuration
options" below).

However, it is often seen that other services like FTP, SFTP, SSH,
WebDAV, etc. are enabled to allow users (for example editors) to place
files such as images, documents, etc. on the server, typically in the
"fileadmin/" folder. It is out of question that this might be seen as
a convenient way to upload files and file transfers via FTP are
simpler and faster to do. The main problem with this is that to enable
"other services" with write access to the document root directory,
bypasses the security measures mentioned above. A malicious PHP script
for example could manipulate or destroy other files – maybe TYPO3 core
files. Sometimes access details of editors are stolen, intercepted or
accidentally fallen into the wrong hands.

The only recommendation from a security perspective is to abandon any
service like FTP, SFTP, etc. which allows to upload files to the
server by bypassing TYPO3.

The TYPO3 Security Team and other IT security experts advance the view
that FTP shall be classified as insecure in general. They have
experienced that many websites have been hacked by a compromised
client and/or unencrypted FTP connections and as a consequence, it is
advised that FTP should not be used at all.

