..  include:: /Includes.rst.txt
..  index:: pair: Crowdin; Extensions
..  _crowdin-extension-integration:

=====================
Extension integration
=====================

This section describes how an extension author can get his extension set up at
:ref:`Crowdin <xliff-translating-server-crowdin>`.

..  note::
    *   Your extension must be on GitHub, GitLab
        (:abbr:`SaaS (Software as a service)` or self-managed) or BitBucket.
    *   Currently, TYPO3 can only handle one branch/version for languages.
        Typically you should select the "main" branch.


Setup
=====

Get in contact with the team in the TYPO3 Slack channel
`#typo3-localization-team`_ with the following information:

#.  Extension name
#.  Your email address for an invitation to Crowdin, so you will get the correct
    role for your project.

..  _#typo3-localization-team: https://typo3.slack.com/app_redirect?channel=CR75200FL


Integration
===========

In a next step you need to configure the integration of your Git provider into
Crowdin. Have a look at the documentation on how to connect your repository with
Crowdin:

*   `GitHub integration <https://support.crowdin.com/github-integration/>`__
*   `GitLab integration <https://support.crowdin.com/gitlab-integration/>`__
*   `BitBucket integration <https://support.crowdin.com/bitbucket-integration/>`__

Happy translating!

..  tip::
    Checkout the :ref:`crowdin-faq` for solutions to common pitfalls.
