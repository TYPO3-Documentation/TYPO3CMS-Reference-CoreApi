:navigation-title: Extension Key

.. include:: /Includes.rst.txt
.. index:: ! Extension key
.. _extension-key:

=========================
Choosing an extension key
=========================

The "extension key" is a string that uniquely identifies the extension.
The folder in which the extension is located is named by this string.

Rules for the Extension Key
===========================

The extension key must comply with the following rules:

* It can contain characters a-z, 0-9 and underscore
* No uppercase characters should be used (folder, file and table/field names
  remain in lowercase).
* Furthermore the key must **not start** with any of these (these are prefixes
  used for modules):

  * **tx**
  * **user_**
  * **pages**
  * **tt_**
  * **sys_**
  * **ts_language**
  * **csh_**

* The key may not start with a number. Also an underscore at the beginning or
  the end is not allowed.
* The length must be between 3 and 30 characters (underscores not included).
* The extension key must still be unique even if underscores are removed,
  since backend modules that refer to the extension should be named by
  the extension key *without* underscores. (Underscores are allowed
  to make the extension key easy to read).

The naming conventions of extension keys are automatically validated
when they are registered in the repository, so you do not have to worry
about this.

There are two ways to name an extension:

- **Project specific extensions** (not generally usable or shareable):
  Select any name you like and prepend it "user\_" (which is the only
  allowed use of a key starting with "u"). This prefix denotes that it is
  a local extension that does not originate from the central TYPO3
  Extension Repository or is ever intended for sharing. Probably this
  is an "adhoc" extension you made for some special occasion.

- **General extensions:** Register an extension name online at the TYPO3
  Extension Repository. Your extension name will be validated automatically
  and you are sure to have a unique name will be returned which no
  one else in the world will use. This makes it very easy to share your
  extension later on with everyone else as it ensures that no
  conflicts will occur with other extensions. But by default, a new
  extension you make is defined as "private", which means no one else but
  you have access to it until you permit it to be public. It's free of
  charge to register an extension name. By definition, all code in the
  TYPO3 Extension Repository is covered by the GPL license because it
  interfaces with TYPO3. You should really consider making general
  extensions!


.. tip::
   It is far easier to settle for the right
   extension key from the beginning. Changing it later involves a cascade
   of name changes to tables, modules, configuration files, etc. Think carefully.

.. _extension-license:

About GPL and extensions
========================

Remember that TYPO3 is GPL software and at the
same moment when you extend TYPO3, your extensions are legally covered by
GPL. This does not *force* you to share your extension, but it should
*inspire* you to do so and legally you cannot prevent anyone who gets
hold of your extension code from using it and further develop it. The
TYPO3 Extension API is designed to make sharing of your work easy as
well as using others' work easy. Remember TYPO3 is Open Source Software
and we rely on each other in the community to develop it further.

.. attention::
   It's also your responsibility to make sure that
   all content of your extensions is legally covered by GPL. The
   webmaster of TYPO3.org reserves the right to kick out any extension
   *without notice* that is reported to contain non-GPL material.

.. _extensions-security:

Security
========

You are responsible for security issues in your
extensions. People may report security issues either directly to you
or to the `TYPO3 Security Team <https://typo3.org/community/teams/security/>`__.
In any case, you should get in
touch with the Security Team which will validate the security fixes.
They will also include information about your (fixed) extension in
their next Security bulletin. If you don't respond to requests from
the Security Team, your extension will be removed by force from the
TYPO3 Extension Repository.

More details on the security team's policy on handling security issues
can be found at https://typo3.org/teams/security/extension-security-policy/.

.. _extension-key-registration:

Registering an extension key
============================

Before starting a new extension you should register an extension key
on extensions.typo3.org (unless you plan to make an implementation-specific
extension – of course – which does not make sense to share).

Go to `extensions.typo3.org <https://extensions.typo3.org>`__, log in with your
(pre-created) username/password and navigate to :guilabel:`My Extensions` in the
menu. Click on the :guilabel:`Register extension key` tab. On that page enter
the extension key you want to register.

.. figure:: /Images/ExternalImages/TER/RegisterExtensionKey.png
   :alt: The extension key registration form
   :class: with-border

   The extension key registration form
