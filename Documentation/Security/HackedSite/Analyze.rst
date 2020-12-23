.. include:: /Includes.rst.txt
.. index:: Hacked site; Analyze
.. _security-analyze:

=======================
Analyzing a hacked site
=======================

In most cases, attackers are adding malicious code to the files on
your server. All files that have code injected need to be cleaned or
restored from the original files. Sometimes it is obvious if an
attacker manipulated a file and placed harmful code in it. The date
and time of the last modification of the file could indicate that an
unusual change has been made and the purpose of the new or changed
code is clear.

In many cases, attackers insert code in files such as :file:`index.php` or
:file:`index.html` that are found in the root of your website. Doing so, the
attacker makes sure that his code will be executed every time the
website is loaded. The code is often found at the beginning or end of
the file. If you find such code, you may want to do a full search of
the content of all files on your hard disk(s) for similar patterns.

However, attackers often try to obscure their actions or the malicious
code. An example could look like the following line::

   eval(base64_decode('dW5saW5rKCd0ZXN0LnBocCcpOw=='));

Where the hieroglyphic string "dW5saW5rKCd0ZXN0LnBocCcpOw==" contains
the PHP command :php:`unlink('test.php');` (base64 encoded), which deletes
the file :file:`test.php` when executed by the PHP function :php:`eval()``.
This is a simple example only and more sophisticated obscurity strategies
are imaginable.

Other scenarios also show that PHP or `JavaScript`:pn: code has been
injected in normal CSS files. In order that the code in those files
will be executed on the server (rather than just being sent to the
browser), modifications of the server configuration are made. This
could be done through settings in an :file:`.htaccess` file or in the
configuration files (such as :file:`httpd.conf`) of the server. Therefore
these files need to be checked for modifications, too.

As described above, fixing these manipulated files is not sufficient.
It is absolutely necessary that you learn which vulnerability the
attacker exploited and to fix it. Check log files and other components
on your system which could be affected, too.

If you have any proof or a reasonable ground for suspecting that `TYPO3`:pn:
or an extension could be the cause, and no security-bulletin lists
this specific version, please :ref:`contact the `TYPO3 Security Team`:pn:
<security-team-contact>`. The policy dictates not to disclose the issue
in public (mailing lists, forums, Twitter or any other third party website).

