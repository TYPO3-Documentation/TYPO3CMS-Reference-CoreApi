.. include:: ../../Includes.txt


.. _publish-extension:

======================
Publish Your Extension
======================

By publishing an extension, we mean making it publicly available. Follow these
four steps, we recommend to do all of these.

*TYPO3 - Inspiring people to share*

.. rst-class:: bignums-xxl

#. Publish Your Extension on Packagist

   This is described well on `Packagist <https://packagist.org/>`__.

   **Advantages:**

   * It is possible to install your extension using `composer require`
   * An update of the extension can be done easily by your users with
     `composer update`


#. Publish Your Extension on TER

   See `Publish an Extension <https://extensions.typo3.org/faq/publish-an-extension/>`__
   for more information on how to publish an extension and check out the
   `FAQ <https://extensions.typo3.org/faq/>`__ as well.

   **Advantages:**

   * The community can vote for your extension
   * Users can subscribe to notifications on new releases
   * Donate link (optional)
   * Link to the documentation (optional)
   * Link to the source code (optional)
   * Link to the issue tracker (optional)


#. Publish Source Code on a Public Git Hosting Platform

   The TYPO3 community currently uses GitHub, GitLab and Atlassian Bitbucket to
   host the Git repositories of their extensions.

   Add a repository to your workspace. Typically, the extension key is used
   for the repository name, but that is not necessary.

   **Advantages:**

   * Contributors can add issues or make pull requests
   * Render the documentation on docs.typo3.org (see next step) by adding a webhook

#. Register Your Extension for docs.typo3.org

   This basically means that you will add a webhook in your extension repository.
   In order for this to work, you must have a :file:`composer.json` and push some
   changes after you register the webhook.

   All the necessary steps are outlined in :ref:`h2document:migrate` except for
   step 4 (request redirects) which is not necessary for new documentation.

   **Advantages:**

   * Your extension will be rendered on `docs.typo3.org <https://docs.typo3.org/>`__
   * The documentation link will be added automatically if your extension is
     registered on `extensions.typo3.org (TER) <https://extensions.typo3.org/>`__.
