.. include:: /Includes.rst.txt
.. index:: Hacked site; Take offline
.. _security-take-offline:

========================
Take the website offline
========================

Assuming you have detected that your site has been hacked, you should
take it offline for the duration of the analysis and restoration
process (the explanations below). This can be done in various ways and
it may be necessary to perform more than one of the following tasks:

* route the domain(s) to a different server

* deactivate the web host and show a "maintenance" note

* disable the web server such as Apache (keep in mind that shutting down
  a web server on a system that serves virtual hosts will make all sites
  inaccessible)

* disconnect the server from the Internet or block access from and to
  the server (firewall rules)

There are many reasons why it is important to take the whole site or
server offline: In the case where the hacked site is used for
distributing malicious software, a visitor who gets attacked by a
virus from your site, will most likely lose the trust in your site and
your services. A visitor who simply finds your site offline (or in
"maintenance mode") for a while will (or at least might) come back
later.

Another reason is that as long as the security vulnerability exists in
your website or server, the system remains vulnerable, meaning that
the attacker could continue harming the system, possibly causing more
damage, while you're trying to repair it. Sometimes the "attacker" is
an automated script or program, not a human.

After the website or server is not accessible from outside, you should
consider to make a full backup of the server, including all available
log files (Apache log, FTP log, SSH log, MySQL log, system log). This
will preserve data for a detailed analysis of the attack and allows
you (and/or maybe others) to investigate the system separated from the
"live" environment.

Today, more and more servers are virtual machines, not physical
hardware. This often makes creating a full backup of a virtual server
very easy because system administrators or hosting providers can
simply copy the image file.

