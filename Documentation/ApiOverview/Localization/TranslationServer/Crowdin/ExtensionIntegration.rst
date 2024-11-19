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

.. _crowdin-extension-integration-github:

Step-by-step instructions for GitHub
------------------------------------


.. _crowdin-extension-integration-github-crowdin-config:

Step 1: Create a Crowdin configuration file
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Within your TYPO3 extension repository, create a :file:`.crowdin.yml` file at root
with the following content:

..  code-block:: yaml

    preserve_hierarchy: 1
    files:
      - source: /Resources/Private/Language/*.xlf
        translation: /%original_path%/%two_letters_code%.%original_file_name%
        ignore:
          - /**/%two_letters_code%.%original_file_name%


.. _crowdin-extension-integration-github-configure:

Step 2: Configure the GitHub integration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In the Crowdin project settings, go to the Integrations tab and click on the button
"Browse Integrations", then choose "GitHub". Follow the instructions to connect your
GitHub repository to Crowdin.

Once installed, the Integrations tab will show the GitHub integration with a button
to "Set Up Integration". Click on it and choose the mode "Source and translation
files mode".

At this point, Crowdin will request additional permissions to access your repository.
You should accept the default permissions and click on the "Authorize crowdin" button.

Then follow the instructions to configure the integration:

#. Select the repository from the list of your GitHub repositories.
#. Select the branch to use for synchronization (usually ``main`` or ``master``).
   - When ticking the branch, Crowdin will suggest a "Service Branch Name"
     ``l10n_main`` (or ``l10n_master``), which is the branch where Crowdin will push
     the translations. You can keep the default value.
#. Click the pencil icon next to the Service Branch Name to edit configuration.
#. When asked for the Configuration file name, change it from ``crowdin.yml`` to
   ``.crowdin.yml`` and click "Continue". This will effectively use the configuration
   we created in Step 1 and ensure that everything is properly configured for your
   TYPO3 extension.
#. Click the "Save" button to save the configuration.
#. Back to the main GitHub integration page, you should see a circled checkmark next
   to the Service Branch Name, indicating that the integration is correctly set up.
#. Ensure the checkbox "One-time translation import after the branch is connected" is
   ticked.
#. Do not tick the checkbox "Push Sources" as the sources are already in the repository
   and changes are managed within the extension repository **and not in Crowdin**.
#. Click the "Save" button to save the configuration of the integration.


.. _crowdin-extension-integration-github-import:

Step 3: Import existing translations
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In case you have local translations, you may do a one-time import by using the Crowdin
web interface and manually importing a zip file with the existing translations.

To prepare the zip file, you can use the following command:

..  code-block:: bash

    zip translations.zip Resources/Private/Language/*.*.xlf

Then go to the Crowdin project, click on the "Translations" tab and drag and drop
the zip file into the area "Upload existing translations".

..  note::

    The import will work best only if the translation files contain both the
    ``<source>`` and ``<target>`` elements. If the ``<source>`` elements are missing,
    Crowdin will not be able to match the translations with the original English labels.

Happy translating!

..  tip::
    Checkout the :ref:`crowdin-faq` for solutions to common pitfalls.
