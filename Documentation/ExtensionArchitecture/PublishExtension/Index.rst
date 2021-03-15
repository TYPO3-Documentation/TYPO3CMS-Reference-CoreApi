.. include:: /Includes.rst.txt


.. _publish-extension:

======================
Publish Your Extension
======================

By publishing an extension, we mean making it publicly available. This includes:

#. :ref:`Register your extension on Packagist <publish-extension-packagist>`
#. :ref:`Register your extension on extensions.typo3.org <publish-extension-ter>` (TER)
#. Make your :ref:`extension source code available <publish-extension-git>`
   on a public Git hoster such as GitHub,
   Gitlab or Bitbucket
#. :ref:`Register Your Extension for docs.typo3.org <publish-extension-docs>`:
   This makes sure your extension documentation will be rendered on
   docs.typo3.org


We recommend to do all of these. Find more information in the following sections.

*TYPO3 - Inspiring people to share*

.. _publish-extension-packagist:

Publish Your Extension on Packagist
====================================================

This is described well on `Packagist <https://packagist.org/>`__.

Advantages:

* It is possible to install your extension using `composer require`

.. _publish-extension-ter:

Publish Your Extension on TER
====================================================


See `Publish an Extension <https://extensions.typo3.org/faq/publish-an-extension/>`__
for more information on how to publish an extension and check out the
`FAQ <https://extensions.typo3.org/faq/>`__ as well.

Advantages:

* The community can vote for your extension
* Donate link (optional)
* Link to the documentation (optional)
* Link to the source code (optional)


.. _publish-extension-git:

Publish Source Code on a Public Git Hosting Platform
====================================================

The TYPO3 community currently uses GitHub, GitLab and Atlassian Bitbucket to host
the Git repositories of their extensions.

Add a repository to your workspace. Typically, the extension key is used
for the repository name, but that is not necessary.

Advantages:

* Contributors can add issues or pull requests
* Render the documentation on docs.typo3.org (see next step) by adding a webhook



.. _publish-extension-docs:

Register Your Extension for docs.typo3.org
==========================================

This basically means that you will add a webhook in your extension repository.
In order for this to work, you must have a :file:`composer.json` and push some
changes after you register the webhook.

All the necessary steps are outlined in :ref:`h2document:migrate` except for
step 4 (request redirects) which is not necessary for new documentation.

Advantages:

   * Your extension documentation will be rendered on `docs.typo3.org <https://docs.typo3.org/>`__
   * The documentation link will be added automatically if your extension is
     registered on extensions.typo3.org (TER).
