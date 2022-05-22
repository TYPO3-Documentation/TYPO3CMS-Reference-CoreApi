.. include:: /Includes.rst.txt
.. index:: Extension development; Publishing
.. _publish-to-ter:

=================================
Publish your extension in the TER
=================================


Before publishing extension, think about
========================================

First of all ask yourself some questions before publishing or even putting some
effort in coding:

*  What additional benefit does your extension have for the TYPO3 community?
*  Does your extension key describe the extension? See the extension key
   requirements.
*  Are there any extensions in the TER yet which have the same functionalities?
*  If yes, why do we need your one? Wouldn't it be an option to contribute to
   other extensions?
*  Did you read and understand the `TYPO3 Extension Security Policy <https://typo3.org/community/teams/security/extension-security-policy>`__?
*  Does your extension include or need external libraries? Watch for the
   license! Learn more about the
   `right licensing <https://typo3.org/project/licenses/>`__.
*  Do you have a public repository on e.g. GitHub, Gitlab or Bitbucket?
*  Do you have the resources to maintain this extension?
*  This means that you should

   *  support users and integrators using your extension
   *  review and test contributions
   *  test your extension for new TYPO3 releases
   *  provide and update a documentation for your extension

Use semantic versions
=====================

We would like you to stick to semantic versions.

Given a version number **MAJOR.MINOR.PATCH**, increment the:

*  **MAJOR** version when you make incompatible API changes (known as
   "**breaking changes**"), 
*  **MINOR** version when you **add functionality in a backwards-compatible
   manner**, and
*  **PATCH** version when you **make backwards-compatible bug fixes**.

Additional labels for pre-release and build metadata are available as extensions
to the **MAJOR.MINOR.PATCH format**.

More you can see at https://semver.org.

Offer feedback options
======================

Before you publish an extension you should be aware of what happens after it.
Users and integrators will give you feedback (contributions, questions,
bug reports). In this case you should have

#. A possibility to get in contact with you (link to an issue tracker like
   forge, GitHub, etc.)
#. A possibility to look into the code (link to a public repository)

You can edit these options in the
`extension key management <https://extensions.typo3.org/my-extensions>`__
(after login)

How to publish an extension
===========================

Now we come to the process of publishing in TER. You have three options for
releasing an extension:

#. Via the web form:

   Click "Upload" next to your extension key in the
   `extension key management <https://extensions.typo3.org/my-extensions>`__
   and follow the instructions.

#. Via the REST interface (recommended):

   Use the PHP CLI application `Tailor <https://github.com/TYPO3/tailor>`__
   which lets you register new extension keys and helps you maintain
   your extensions, update extension information and publish new extension
   versions. For complete instructions and examples, see the official
   :doc:`Tailor documentation <tailor:Index>`.

   Besides manual publishing, *Tailor* is the perfect complement for
   automatic publishing via CI / CD pipelines. On the application's homepage
   you will find integration snippets and below recommended tools that further
   simplify the integration into common CI / CD pipelines:

   GitHub: https://github.com/tomasnorre/typo3-upload-ter

#. Via the SOAP interface (deprecated):

   Use the PHP CLI application
   `TYPO3 Repository Client <https://github.com/NamelessCoder/typo3-repository-client>`__
   , or the `TER Client <https://github.com/helhum/ter-client>`__ based on the
   TYPO3 Repository Client.

