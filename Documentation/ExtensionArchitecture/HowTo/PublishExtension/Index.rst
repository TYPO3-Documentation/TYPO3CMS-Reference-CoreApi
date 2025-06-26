:navigation-title: Publishing

.. include:: /Includes.rst.txt
.. index:: Extension development; Publishing
.. _publish-extension:

======================
Publish your extension
======================

Follow these steps to release your extension publicly in the TYPO3 world:

#. :ref:`Publish the source code on a public Git hosting platform <publishExtensionGit>`
#. :ref:`Publish your extension on Packagist <publishExtensionPackagist>`
#. :ref:`Publish your extension on TER <publishExtensionTer>`
#. :ref:`Publish its documentation in the official TYPO3 documentation <publishExtensionDocumentation>`
#. :ref:`Set up translations <publishExtensionTranslation>` on Crowdin

– *TYPO3 - Inspiring people to share*

.. index:: Extension development; Git

.. _publishExtensionGit:

Git
===

Publish your source code on a public Git hosting platform.

The TYPO3 community currently uses GitHub, GitLab and Atlassian Bitbucket to
host the Git repositories of their extensions.

Typically, the :ref:`extension key <extension-key>` is used for the
repository name, but that is not necessary.

**Advantages:**

*  Contributors can add issues or make pull requests.
*  Documentation can be published in the official TYPO3 documentation
   by using a webhook (see below).

.. index:: Extension development; Packagist

.. _publishExtensionPackagist:

Packagist
=========

Publish your extension on `Packagist <https://packagist.org/>`__
- the main Composer repository.

See their `homepage <https://packagist.org/>`__ for more details
about the publishing process.

**Depends on:**

*  Public Git repository
*  Valid :ref:`composer.json <composer-json>`

**Advantages:**

*  Extension can be installed in a
   :ref:`Composer based <t3start:install>`
   TYPO3 instance using `composer require`.
*  All advantages of being listed in Packagist, for example

   *  Extension can be updated easily with `composer update`

.. index:: Extension development; TER

.. _publishExtensionTer:

TER
===

Publish your extension in the
`TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__
- the central storage for public TYPO3 extensions.

See page :ref:`publish-to-ter` for more information about the
publishing process and check out the TYPO3 community Q&A at
page `FAQ <https://extensions.typo3.org/faq/>`__.

**Depends on:**

*  :ref:`Extension key <extension-key>` registered in TER

**Advantages:**

*  Extension can be installed in a
   :ref:`Classic mode installation (no Composer required) <classic-installation>`
   TYPO3 instance using the module :ref:`Extensions <extension-manager>`.
*  All advantages of being listed in the TER, for example:

   *  Easy finding of your extension
   *  Reserved extension key in the TYPO3 world
   *  The community can vote for your extension
   *  Users can subscribe to notifications on new releases
   *  Composer package is announced (optional)
   *  Sponsoring link (optional)
   *  Link to the documentation (optional)
   *  Link to the source code (optional)
   *  Link to the issue tracker (optional)

.. index:: Extension development; webhook for documentation

.. _publishExtensionDocumentation:

Documentation
=============

Publish the documentation of your extension in the
`official TYPO3 documentation <https://docs.typo3.org/>`__.

Please follow the instructions on page :ref:`h2document:migrate` to set up
an appropriate webhook.

**Depends on:**

*  Public Git repository
*  Extension published in TER (optional).
   This is not mandatory, but makes the webhook approval easier for the TYPO3
   Documentation Team.

**Advantages:**

*  Easily find your extension documentation, which serves as a good companion
   for getting started with your extension.

.. _publishExtensionTranslation:

Crowdin
=======

If you use language labels which should get translated in your extension
(typically in :file:`Resources/Private/Languages`),
you may want to configure the translation setup on https://crowdin.com.
Crowdin is the official translation server for TYPO3.

This is documented on :ref:`crowdin-extension-integration`.

Further reading
===============

.. toctree::
   :maxdepth: 3
   :titlesonly:
   :glob:

   PublishToTER/Index
