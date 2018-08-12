.. include:: ../../Includes.txt


.. _password-hashing:

================
Password hashing
================


.. _password-hashing-introduction:

Introduction
============

TYPO3 never stores passwords in plain text in the database and updates stored frontend and
backend user password hashes to the latest configured hash algorithm upon user login.

TYPO3 uses modern hash algorithms suitable for the given PHP platforms, the default since
TYPO3 core version v9 is Argon2i.

This section is for administrators and users who want to know more about TYPO3 password hashing,
their basic understanding and configuration in TYPO3.


.. _password-hashing-basic-knowledge:

Basic knowledge
===============

Storing plain text passwords to simply compare a stored password with a given user password when
the user logs in has been a common attack vector in online systems ever since.
The main risk is that some other system vulnerability or chain of vulnerabilities
allows an attacker to download the frontend or backend database user table and then knows
the plain text passwords of users. These passwords can then be used to log in as the specific
user to get their TYPO3 instance specific privileges (for instance a backend admin)
and - usually even worse - are often abused by attackers to try the same user / password combination
at different services. Maybe, the user uses the same login email and password for his bank account?

To mitigate this risk, one-way hash algorithms have been invented: The given password is one-way
transformed to some different string (a hash), this hash is stored in the database instead of the
plain text password. The idea is if you see the hash, you can not calculate back to the plain text
password easily. That's why hashes are called "one-way": It's easy to calculate a hash from given
password, but it is expensive (in terms of computation time) to calculate a password from a given hash. If a user
tries to log in and submits its password, the same one-way transformation is done again, if it is then identical
with the hash stored in the database, the submitted password must have been correct and the login is granted.

The most well-known hash algorithm is md5. Those basic hash algorithms and especially md5 have drawbacks,
tough: First, if you find some other string that resolves to the same hash, you are screwed (that's called
a collision). An attacker could login with a password that is not identical to "your" password, but still matches
the calculated hash. And second, if an attacker just calculates a huge list of all possible password with their
representing hashes (this is called a rainbow table) and puts them into a database to compare any given hash with,
it can easily look up plain text passwords for given hashes. A simple md5 hash is susceptible to both of these
attack vectors and thus deemed insecure. md5 rainbow tables for casual passwords can be found online and md5 collision
creation can be done with without too many issues. In short: md5 is not a good idea to secure user passwords.

To mitigate the rainbow table attack vector, the idea of "salting" has been invented: Instead of
hashing the given password directly and always ending up with the same hash for the same password
(if different users use the same password they end up with the same hash in database), a "salt"
is added to the password. This salt is a random string calculated when the password is first set (when the
user record is created) and stored *together* with the hash. The basic thinking is that the salt is
appended to the password before hashing, the "salt+password" combination is then hashed. The salt is stored
next to the hash in the database. If then a user logs in and submits its user name and password, the requested user
is looked up in the database, the salt of this user is looked up in the database, the submitted password
is concatenated with the salt, the salt and password combination are then hashed and compared with the stored
hash. This is pretty clever and leads to the situation that users with the same password end up with different
hashes in the database since their random calculated salt is different. This effectively makes rainbow
tables (direct hash to password lists) unfeasible.

During the past years, further attack vectors to salted password hashes have been found. For example,
md5 hash attacks have been optimized such they are extremely quick on some platforms, those can calculate
billions of hashes per second with decent time and money efforts. This allows password guessing even with
salted hashes. Modern hash algorithms thus try to mitigate these attack vectors. Their hash calculation
is expensive in terms of memory and CPU time even for short input string like passwords
(short as in "not a book of text") and they can not be easily split into parallel sections to run on many
systems in parallel or optimized into chunks by re-using already computed sections for different input again.

TYPO3 improved its standards in password hash storing over a long time and always went with more modern
approaches: Core version v4.3 from 2009 added salted password storing, v4.5 from 2011 added salted passwords
storing using algorithm 'phpass' by default, v6.2 from 2014 made salted passwords storing mandatory,
v8 added the improved hash algorithm 'pbkdf2' and used it by default.

With core v9, the password hashing has been refactored and modern hash algorithms like especially
Argon2i have been added. PHP improved in this area a lot and PHP 7.2 brings Argon2i by default, so this
algorithm could be easily integrated as available core hash mechanism to the existing hash family.
Argon2i is rather resilient against GPU and some other attacks, the default TYPO3 core configuration even raises
the default PHP configuration to make attacks on stored argon2i user password hashes even more unfeasible.

This is the current state if you are reading this document. The rest is about details: It is possible
to register own password hash algorithms with an extension if you really think this is needed, it is possible
to change options for frontend and backend users hash algorithms. By default however, TYPO3 automatically selects
a good password hash algorithm and administrators usually do not have to take care of it. The PHP API
is pretty straight forward and helps you to compare passwords with their stored hashes if needed in
extensions.

One last point on this basic hash knowledge section: Password hashes are always only as secure as
the user submitted password: If a user has a trivial password like "foo", an attacker who got hold
of the salted password hash will always be successful to crack the hash with a common password hash
crack tool, no matter how expensive the calculation is. Good password hashing does **not** rescue
users from short passwords or simple passwords that can be found in a dictionary. It is usually a
good idea to force users to register with a password that for instance at least has some minimum length.



