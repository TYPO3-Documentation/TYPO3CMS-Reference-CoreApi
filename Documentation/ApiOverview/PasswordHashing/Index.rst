.. include:: /Includes.rst.txt
.. index:: Password hashing
.. _password-hashing:

================
Password hashing
================

..  versionchanged:: 13.0
    The default hash algorithm has been changed from Argon2i to Argon2id.

.. _password-hashing-introduction:

Introduction
============

TYPO3 never stores passwords in plain text in the database. If the latest configured hash algorithm has been changed,
TYPO3 will update the stored frontend and backend user password hashes upon user login.

TYPO3 uses modern hash algorithms suitable for the given PHP platform, the
default being Argon2id.

This section is for administrators and users who want to know more about TYPO3 password hashing and
have a basic understanding of hashing algorithms and configuration in TYPO3.


.. _password-hashing-basic-knowledge:

Basic knowledge
===============

If a database has been compromised and the passwords have been stored as plain text,
the attacker has most likely gained access to more than just the user's TYPO3 Frontend / Backend account.
It's not uncommon for someone to use the same email and password combination for more than one online service,
such as their bank account, social media accounts, or even their email provider.

To mitigate this risk, we can use one-way `hash`_ algorithms to transform a plain text password into an incomprehensible
string of seemingly "random" characters.
A hash, (also known as a checksum), is the result of a value (in this case the user's password) that has been
transformed using a one-way function.
Hashes are called "one-way functions" because they're quick and easy to generate, but incredibly hard to undo.
You would require an incredible amount of computational power and time to try and reverse a hash back to its original
value.

When a user tries to log in and submits their password through the login form, the same one-way function is performed
and the result is compared against the hash stored in the database. If they're the same, we can safely assume the user
typed in the correct password without ever needing to store their actual password!

The most well-known hash algorithm is MD5. Basic hash algorithms and especially MD5 have drawbacks though:
First, if you find some other string that resolves to the same hash, you're screwed (that's called
a collision). An attacker could login with a password that is not identical to "your" password, but still matches
the calculated hash. And second, if an attacker just calculates a huge list of all possible passwords with their
matching hashes (this is called a rainbow table) and puts them into a database to compare any given hash with,
it can easily look up plain text passwords for given hashes. A simple MD5 hash is susceptible to both of these
attack vectors and thus deemed insecure. MD5 rainbow tables for casual passwords can be found online and MD5 collision
creation can be done without too many issues. In short: MD5 is not a suitable hashing algorithm for securing user passwords.

To mitigate the rainbow table attack vector, the idea of "salting" has been invented: Instead of
hashing the given password directly and always ending up with the same hash for the same password
(if different users use the same password they end up with the same hash in the database), a "salt"
is added to the password. This salt is a random string calculated when the password is first set (when the
user record is created) and stored *together* with the hash. The basic thinking is that the salt is
added to the password before hashing, the "salt+password" combination is then hashed. The salt is stored
next to the hash in the database. If then a user logs in and submits their username and password, the following
happens:

1. the requested user is looked up in the database,
2. the salt of this user is looked up in the database,
3. the submitted password is concatenated with the salt of the user,
4. the "salt+password" combination is then hashed and compared with the stored hash of the user.

This is pretty clever and leads to the situation that users with the same password end up with different
hashes in the database since their randomly calculated salt is different. This effectively makes rainbow
tables (direct hash to password lists) unfeasible.

During the past years, further attack vectors to salted password hashes have been found. For example,
MD5 hash attacks have been optimized such they are extremely quick on some platforms, where billions of
hashes per second can be calculated with decent time and money efforts. This allows for easy password guessing, even with
salted hashes. Modern password hash algorithms thus try to mitigate these attack vectors. Their hash calculation
is expensive in terms of memory and CPU time even for short input string like passwords
(short as in "not a book of text") and they can not be easily split into parallel sections to run on many
systems in parallel or optimized into chunks by re-using already computed sections for different input again.

TYPO3 improved its standards in `password hash`_ storing over a long time and always went with more modern
approaches: Core version v4.3 from 2009 added salted password storing, v4.5 from 2011 added salted passwords
storing using the algorithm 'phpass' by default, v6.2 from 2014 made salted passwords storing mandatory,
v8 added the improved hash algorithm 'PBKDF2' and used it by default.

Currently, Argon2id is the default and provided automatically by PHP.
Argon2id is rather resilient against GPU and some other attacks, the default TYPO3 Core configuration even raises
the default PHP configuration to make attacks on stored Argon2id user password hashes even more unfeasible.

This is the current state if you are reading this document. The rest is about details: It is possible
to register own password hash algorithms with an extension if you really think this is needed. And it is possible
to change options for frontend and backend user hash algorithms. By default however, TYPO3 automatically selects
a good password hash algorithm and administrators usually do not have to take care of it. The PHP API
is pretty straight forward and helps you to compare passwords with their stored hashes if needed in
extensions.

One last point on this basic hash knowledge section: Password hashes are always only as secure as
the chosen password: If a user has a trivial password like "foo", an attacker who has gotten hold
of the salted password hash will always be successful to crack the hash with a common password hash
crack tool, no matter how expensive the calculation is. Good password hashing does **not** rescue
users from short passwords, or simple passwords that can be found in a dictionary. It is usually a
good idea to force users to register with a password that has for instance at least some minimum length
and contains even some special characters. See also :ref:`password-policies`.


What does it look like?
=======================

Below is an example of a frontend user with its stored password hash. Since TYPO3 can handle multiple
different hash mechanisms in parallel, each hash is prefixed with a unique string that identifies the
used hash algorithm. In this case it is `$argon2id` which denotes the Argon2id hash algorithm:

.. code-block:: none
   :caption: Data of a frontend user in the database

   MariaDB [cms]> SELECT uid,username,password FROM fe_users WHERE uid=2;
   +-----+----------+----------------------------------------------------------------------------------------------------+
   | uid | username | password                                                                                           |
   +-----+----------+----------------------------------------------------------------------------------------------------+
   |   2 | someuser | $argon2id$v=19$m=65536,t=16,p=1$NkVhNmt5Ynl6ZDRkV1RlZw$16iztnV7xYJDlsG0hEL9sLGDGFC/WQx34ogfoWHBVJI |
   +-----+----------+----------------------------------------------------------------------------------------------------+
   1 row in set (0.01 sec)


.. index:: Password hashing; Configuration

Configuration
=============

Configuration of password hashing is done by TYPO3 automatically and
administrators usually do not need to worry about details too much: The
installation process will configure the best available hash algorithm by default.
Some of the most secure algorithms currently are Argon2i and Argon2id. Only if the PHP build is incomplete, some less secure
fallback will be selected.

Switching between hash algorithms in a TYPO3 instance is unproblematic: Password hashes of the old selected
algorithm are just kept but newly created users automatically use the new configured hash algorithm. If a user
successfully logs in and a hash in the database for that user is found that uses an algorithm no longer
configured as default hash algorithm, the user password hash will be upgraded to it. This way, existing user password hashes are updated to newer and better hash algorithms over time, upon login.

Note that "dead" users (users that don't use the site anymore and never login) will thus never get their
hashes upgraded to better algorithms. This is an issue that can't be solved on this hash level directly since
upgrading the password hash always requires the plain text password submitted by the user. However, it is a
good idea to clean up dead users from the database anyway. Site administrators should establish processes to
comply with the idea of data minimisation of person related data (General Data Protection Regulation, GDPR). TYPO3 helps here for instance with the
"Table garbage collection" task of the scheduler extension.
See :ref:`Scheduler: Garbage Collection <ext_scheduler:table-garbage-collection-task>`

To verify and select which specific hash algorithm is currently configured for frontend and backend users, a
preset of the settings module is available. It can be found in
:guilabel:`System > Settings
> Configuration presets > Password hashing settings`:

..  figure:: /Images/ManualScreenshots/AdminTools/PasswordHashingSettings.png
    :class: with-shadow
    :alt: Argon2id active for frontend and backend users

    Argon2id active for frontend and backend users

The image shows settings for an instance that runs with frontend and backend users having their passwords
stored as Argon2id hashes in the database. You should use one of the Argon2 algorithms, as the other listed algorithms are deemed less secure.
They rely on different PHP capabilities and might be suitable fall backs, if Argon2i or Argon2id are not available for whatever
reason.


.. index::
   TYPO3_CONF_VARS; SYS availablePasswordHashAlgorithms
   TYPO3_CONF_VARS; FE passwordHashing
   TYPO3_CONF_VARS; BE passwordHashing

Configuration options
=====================

Configuration of password hashing is stored in :file:`config/system/settings.php` with defaults in
:t3src:`core/Configuration/DefaultConfiguration.php` at five places:

:ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['availablePasswordHashAlgorithms'] <typo3ConfVars_sys_availablePasswordHashAlgorithms>`
    An array of class names. This is the list of available password hash
    algorithms. Extensions may extend this list if they need to register new
    (and hopefully even more secure) hash algorithms.

:ref:`$GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']['className'] <typo3ConfVars_be_passwordHashing_className>`
    The salt class name configured as default hash mechanism for frontend users.

:ref:`$GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']['options'] <typo3ConfVars_be_passwordHashing_options>`
    Special options of the configured hash algorithm. This is usually an empty
    array to fall back to defaults, see below for more details.



.. index:: Password hashing;
.. _password-hashing-available-algorithms:

Available hash algorithms
=========================

The list of available hash mechanisms is pretty rich and may be extended further
if better hash algorithms over time. Most algorithms have additional configuration options that may be
used to increase or lower the needed computation power to calculated hashes. Administrators usually do
not need to fiddle with these and should go with defaults configured by the Core. If changing these options,
administrators should know exactly what they are doing.


.. index:: Password hashing;

Argon2i / Argon2id
------------------

`Argon2`_ is a modern key derivation function that was selected as the winner of the Password Hashing
Competition in July 2015. There are two available versions:

* `Argon2i`: should be available on all PHP builds since PHP version 7.2.
* `Argon2id`: should be available on all PHP builds since PHP version 7.3.

Options:

* memory_cost: Maximum memory (in kibibytes) that may be used to compute the Argon2 hash. Defaults to 65536.
* time_cost: Maximum amount of time it may take to compute the Argon2 hash. This is the execution time, given in number of iterations. Defaults to 16.
* threads: Number of threads to use for computing the Argon2 hash. Defaults to 2.


.. index:: Password hashing;

bcrypt
------

`bcrypt`_ is a password hashing algorithm based on blowfish and has been presented in 1999. It needs some
additional quirks for long passwords in PHP and should only be used if Argon2i is not available. Options:

* cost: Denotes the algorithmic time cost that should be used, given in number of iterations. Defaults to 12.


.. index:: Password hashing;

PBKDF2
------

`PBKDF2`_ is a key derivation function recommended by IETF in RFC 8018 as part of the PKCS series, even
though newer password hashing functions such as Argon2i are designed to address weaknesses of PBKDF2.
It could be a preferred password hash algorithm if storing passwords in a FIPS compliant way is necessary. Options:

* hash_count: Number of hash iterations (time cost). Defaults to 25000.


.. index:: Password hashing;

phpass
------

`phpass`_ phpass is a portable public domain password hashing framework for use in PHP applications since 2005.
The implementation should work on almost all PHP builds. Options:

* hash_count: The default log2 number of iterations (time cost) for password stretching. Defaults to 14.


.. index:: Password hashing;

blowfish
--------

TYPO3's salted password hash implementation based on `blowfish`_ and PHP`s crypt() function.
It has been integrated very early to TYPO3 but should no longer be used. It is only included for instances
that still need to upgrade outdated password hashes to better algorithms. Options:

* hash_count: The default log2 number of iterations for password stretching. Defaults to 7.

md5salt
-------

TYPO3's salted password hash implementation based on `md5`_ and PHP`s crypt() function.
It should not be used any longer and is only included for instances that still need
to upgrade outdated password hashes to better algorithms.


PHP API
=======

Creating a hash
---------------

To create a new password hash from a given plain-text password, these are the steps to be done:

* Let the factory deliver an instance of the default hashing class with given context `FE` or `BE`
* Create the user password hash

Example implementation for TYPO3 frontend:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   // Given plain text password
   $password = 'someHopefullyGoodAndLongPassword';
   $hashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance('FE');
   $hashedPassword = $hashInstance->getHashedPassword($password);

Checking a password
-------------------

To check a plain-text password against a password hash, these are the steps to be done:

* Let the factory deliver an instance of the according hashing class
* Compare plain-text password with salted user password hash

Example implementation for TYPO3 frontend:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
   // ...
   // Given plain-text password
   $password = 'someHopefullyGoodAndLongPassword';
   // The stored password hash from database
   $passwordHash = 'YYY';
   // The context, either 'FE' or 'BE'
   $mode = 'FE';
   $success = GeneralUtility::makeInstance(PasswordHashFactory::class)
       ->get($passwordHash, $mode) # or getDefaultHashInstance($mode)
       ->checkPassword($password, $passwordHash);

Adding a new hash mechanism
---------------------------

To add an additional hash algorithm, these steps are necessary:

*   Create a new class that implements interface
    :t3src:`core/Classes/Crypto/PasswordHashing/PasswordHashInterface.php`
*   Register the class as additional entry in
    :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['availablePasswordHashAlgorithms'] <typo3ConfVars_sys_availablePasswordHashAlgorithms>`


.. _hash: https://en.wikipedia.org/wiki/Cryptographic_hash_function
.. _password hash: https://en.wikipedia.org/wiki/Key_derivation_function
.. _Argon2: https://en.wikipedia.org/wiki/Argon2
.. _bcrypt: https://en.wikipedia.org/wiki/Bcrypt
.. _PBKDF2: https://en.wikipedia.org/wiki/PBKDF2
.. _phpass: https://www.openwall.com/phpass/
.. _blowfish: https://en.wikipedia.org/wiki/Blowfish_(cipher)
.. _md5: https://en.wikipedia.org/wiki/MD5


More information
================

.. toctree::
   :titlesonly:
   :maxdepth: 1

   Troubleshooting
