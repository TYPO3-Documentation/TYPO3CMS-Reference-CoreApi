.. include:: /Includes.rst.txt
.. index:: Extension development; Publishing
.. _publish-extension:

======================
Publish your extension
======================

By publishing an extension to the
`TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__, we mean
making it publicly available. Follow these four steps, we recommend to do all
of these.

*TYPO3 - Inspiring people to share*

.. index:: Extension development; GIT
.. rst-class:: bignums-xxl

#. Publish source code on a public GIT hosting platform

   The TYPO3 community currently uses GitHub, GitLab and Atlassian Bitbucket to
   host the GIT repositories of their extensions.

   Typically, the :ref:`extension key <extension-key>` is used for the
   repository name, but that is not necessary.

   **Advantages:**

   * Contributors can add issues or make pull requests
   * Render the documentation on docs.typo3.org (see below) by adding a webhook

.. index:: Extension development; Packagist

#. Publish your extension on Packagist

   This is described well on `Packagist <https://packagist.org/>`__.

   **Depends on:**

   * Public GIT repository

   **Advantages:**

   * It is possible to install your extension using `composer require`
   * An update of the extension can be done easily by your users with
     `composer update`

.. index:: Extension development; TER

#. Publish your extension on TER

   See `Publish an Extension <https://extensions.typo3.org/faq/publish-an-extension/>`__
   for more information on how to publish an extension and check out the
   `FAQ <https://extensions.typo3.org/faq/>`__ as well.

   **Advantages:**

   * Easy finding of your extension in the central Extension Repository
   * The community can vote for your extension
   * Users can subscribe to notifications on new releases
   * Composer package is announced (optional)
   * Sponsoring link (optional)
   * Link to the documentation (optional)
   * Link to the source code (optional)
   * Link to the issue tracker (optional)

.. index:: Extension development; webhook for documentation

#. Add webhook for documentation

   In order for this to work, you must have a :file:`composer.json` and push
   some changes after you registered the webhook.

   All the necessary steps are outlined in :ref:`h2document:migrate` except for
   step 4 (request redirects) which is not necessary for new documentation.

   **Depends on:**

   * Public GIT repository
   * Extension published to TER (This is not strictly necessary for documentation
     rendering. But it makes the workflow easier for the Documentation Team,
     specifically for the approval process if your extension is already registered
     on extensions.typo3.org).

   **Advantages:**

   * Your extension documentation will be rendered on `docs.typo3.org <https://docs.typo3.org/>`__
   * The documentation link will be added automatically if your extension is
     registered on extensions.typo3.org (TER).
