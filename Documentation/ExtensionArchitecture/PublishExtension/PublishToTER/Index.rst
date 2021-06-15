.. include:: /Includes.rst.txt
.. index:: Extension development; Publishing
.. _publish-extension:

========================================================
Publish your extension to the Extension Repository (TER)
========================================================


Before publishing extension, think about
========================================

First of all ask yourself some questions before publishing or even putting some effort in coding:

* What additional benefit does your extension have for the TYPO3 community?
* Does your extension key describe the extension? See the extension key requirements.
* Are there any extensions in the TER yet which have the same functionalities?
* If yes, why do we need your one? Wouldn't it be an option to contribute to other extensions?
* Did you read and understand the `TYPO3 Extension Security Policy <https://typo3.org/community/teams/security/extension-security-policy>`__?
* Does your extension include or need external libraries? Watch for the license! Learn more about the `right licensing <https://typo3.org/project/licenses/>`__.
* Do you have a public repository on e.g. GitHub, Gitlab or Bitbucket?
* Do you have the resources to maintain this extension?
* This means that you should

  * support users and integrators using your extension
  * review and test contributions
  * test your extension for new TYPO3 releases
  * provide and update a documentation for your extension

Use semantic versions
=====================

We would like you to stick to semantic versions.

Given a version number **MAJOR.MINOR.PATCH**, increment the:

* **MAJOR** version when you make incompatible API changes (known as "**breaking changes**"), 
* **MINOR** version when you **add functionality in a backwards-compatible manner**, and
* **PATCH** version when you **make backwards-compatible bug fixes**.

Additional labels for pre-release and build metadata are available as extensions to the **MAJOR.MINOR.PATCH format**.

More you can see at `https://semver.org <https://semver.org>`__

Offer feedback options
======================

Before you publish an extension you should be aware of what happens after it. Users and integrators will give you
feedback (contributions, questions, bug reports). In this case you should have

#. A possibility to get in contact with you (link to an issue tracker like forge, GitHub, etc.)
#. A possibility to look into the code (link to a public repository)

You can edit these options in the `extension key management <https://extensions.typo3.org/my-extensions>`__ (after login)

How to publish an extension
===========================

Now we come to the process of publishing. You have two possibilites to release an extension:

#. Via the web form on extensions.typo3.org (click on "Publish" next to your extension key in the `extension key management <https://extensions.typo3.org/my-extensions>`__).
#. Via `Tailor <https://github.com/TYPO3/tailor>`__: Tailor is a CLI application to help you maintain your extensions. Tailor talks with the TER REST API and enables you to register new keys, update extension information and publish new versions to the extension repository. (recommended)
#. Via the SOAP interface using a tool like the `TYPO3 Repository Client <https://github.com/NamelessCoder/typo3-repository-client>`__ (`Documentation <https://github.com/NamelessCoder/typo3-repository-client#typo3-repository-client-apicli>`__) or the `TER client <https://github.com/helhum/ter-client>`__ (`Documentation <https://github.com/helhum/ter-client#ter-client>`__) (deprecated)


