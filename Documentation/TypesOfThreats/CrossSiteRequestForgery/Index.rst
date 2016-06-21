.. include:: ../../Includes.txt


.. _xsrf:

Cross Site Request Forgery (XSRF)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In this type of attack unauthorized commands are sent from a user a
website trusts. Consider an editor that is logged in to an application
(like a CMS or online banking service) and therefore is authorized in
the system. The authorization may be stored in a session cookie in the
browser of the user. An attacker might send an e-mail to the person
with a link that points to a website with prepared images. When the
browser is loading the images, it might actually send a request to the
system where the user is logged in and execute commands in the context
of the logged-in user.

One way to prevent this type of attack is to include a secret token
with every form or link that can be used to check the authentication
of the request.

