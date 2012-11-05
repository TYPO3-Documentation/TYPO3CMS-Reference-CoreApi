.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _detect:

Detect a hacked website
^^^^^^^^^^^^^^^^^^^^^^^

Typical signs which could indicate that a website or the server was
hacked are listed below. Please note that these are common situations
and examples only, others have been seen. Even if you are the victim
of one of them only, it does not mean that the attacker has not gained
more access or further damage (e.g. stolen user details) has been
done.


.. _detect-manipulated-frontpage:

Manipulated frontpage
"""""""""""""""""""""

One of the most obvious "hacks" are manipulated landing or home page
or other pages. Someone who has compromised a system and just wants to
be honored for his/her achievement, often replaces a page (typically
the home page as it is usually the first entry point for most of the
visitors) with other content, e.g. stating his/her nickname or
similar.

Less obvious is manipulated page content that is only visible to
specific IP addresses, browsers (or other user agents), at specific
date times, etc. It depends on the nature and purpose of the hack but
in this case usually an attacker tries either to target specific users
or to palm keywords/content off on search engines (to manipulate a
ranking for example). In addition, this might obscure the hack and
makes it less obvious, because not everybody actually sees it.
Therefore, it is not sufficient to just check the generated output
because it is possible that the malicious code is not visible at a
quick glance.


.. _detect-malicious-html-code:

Malicious code in the HTML source
"""""""""""""""""""""""""""""""""

Malicious code (e.g. JavaScript, iframes, etc.) placed in the HTML
source code (the code that the system sends to the clients) may lead
to XSS attacks, display dubious content or redirect visitors to other
websites. Latter could steal user data if the site which the user was
redirected to convinces users to enter their access details (e.g. if
it looks the same as or similar to your site).

Also see the explanations below ("Search engines warn about your
site").


.. _detect-embedded-elements:

Embedded elements in the site's content
"""""""""""""""""""""""""""""""""""""""

Unknown embedded elements (e.g. binary files) in the content of the
website, which are offered to website visitors to download (and maybe
execute), and do not come from you or your editors, are more than
suspicious. A hacker possibly has placed harmful files (e.g. virus-
infected software) on your site, hoping your visitors trust you and
download/execute these files.

Also see the explanations below ("Reports from visitors or users").


.. _detect-unusual-traffic:

Unusual traffic increase or decrease
""""""""""""""""""""""""""""""""""""

A significant unusual, unexpected increase of traffic may be an
indication that the website was compromised and large files have been
placed on the server, which are linked from forums or other sites to
distribute illegal downloads. Increased traffic of outgoing mail could
indicate that the system is used for sending "spam" mail.

The other extreme, a dramatic and sudden decrease of traffic, could
also be a sign of a hacked website. In the case where search engines
or browsers warn users that "this site may harm your computer", they
stay away.

In a nutshell, it is recommended that you monitor your website and
server traffic in general. Significant changes in this traffic
behavior should definitely make you investigating the cause.


.. _detect-reports:

Reports from visitors or users
""""""""""""""""""""""""""""""

If visitors or users report that they get viruses from browsing
through your site, or that their anti-virus software raises an alarm
when accessing it, you should immediately check this incident. Keep in
mind that under certain circumstances the manipulated content might
not be visible to you if you just check the generated output; see
explanations above.


.. _detect-warnings:

Search engines or browsers warn about your site
"""""""""""""""""""""""""""""""""""""""""""""""

Google, Yahoo and other search engines have implemented a warning
system showing if a website content has been detected as containing
harmful code and/or malicious software (so called "malware" that
includes computer viruses, worms, trojan horses, spyware, dishonest
adware, scareware, crimeware, rootkits, and other malicious and
unwanted software).

One example for such a warning system is Google's "Safe Browsing
Database". This database is also used by various browsers.


.. _detect-leaked-credentials:

Leaked credentials
""""""""""""""""""

One of the "hacks" most difficult to detect is the case where a hacker
gained access to a perfectly configured and secured TYPO3 site. In
previous chapters we discussed how important it is to use secure
passwords, not to use unencrypted connections, not to store backups
(e.g. MySQL database "dumpfiles") in a publicly accessible directory,
etc. All these examples could lead to the result that access details
fall into the hands of an attacker, who possibly uses them, simply
logs into your system and edits some pages as a usual editor.

Depending on how sophisticated, tricky, small and frequently the
changes are and how large the TYPO3 system is (e.g. how many editors
and pages are active), it may take a long time to realize that this is
actually a hack and possibly takes much longer to find the cause,
simply because there is no technical issue but maybe an organizational
vulnerability.

The combination of some of the recommendations in this document
reduces the risk (e.g. locking backend users to specific IP addresses,
store your backup files outside the web server's document root, etc.).

