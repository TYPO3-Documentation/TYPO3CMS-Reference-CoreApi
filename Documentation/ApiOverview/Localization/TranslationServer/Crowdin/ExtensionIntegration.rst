:navigation-title: Extension integration

..  include:: /Includes.rst.txt
..  index:: pair: Crowdin; Extensions
..  _crowdin-extension-integration:

===================================
Integrate Crowdin in your extension
===================================

This section describes how an extension author can get his extension set up at
:ref:`Crowdin <xliff-translating-server-crowdin>`.

..  note::
    *   Your extension must be on GitHub, GitLab
        (:abbr:`SaaS (Software as a service)` or self-managed) or BitBucket.
    *   Currently, TYPO3 can only handle one branch/version for languages.
        Typically you should select the "main" branch.

..  _crowdin-extension-integration-setup:

Setup Crowdin
=============

Get in contact with the team in the TYPO3 Slack channel
`#typo3-localization-team`_ with the following information:

#.  Extension name
#.  Your email address for an invitation to Crowdin, so you will get the correct
    role for your project.

..  _#typo3-localization-team: https://typo3.slack.com/app_redirect?channel=CR75200FL

.. _crowdin-extension-integration-github:

Integration in GitHub or GitLab
===============================

In a next step you need to configure the integration of your Git provider into
Crowdin. Have a look at the documentation on how to connect your repository with
Crowdin:

*   `GitHub integration <https://support.crowdin.com/github-integration/>`__
*   `GitLab integration <https://support.crowdin.com/gitlab-integration/>`__
*   `BitBucket integration <https://support.crowdin.com/bitbucket-integration/>`__

..  _crowdin-extension-integration-github-crowdin-config:
..  _crowdin-extension-integration-github-configure:

Step-by-step instructions for GitHub
------------------------------------

..  rst-class:: bignums-xxl

1.  Create a Crowdin configuration file

    Within your TYPO3 extension repository, create a :file:`.crowdin.yml` file at root
    with the following content:

    ..  code-block:: yaml
        :caption: EXT:my_extension/.crowdin.yml

        preserve_hierarchy: 1
        files:
          - source: /Resources/Private/Language/*.xlf
            translation: /%original_path%/%two_letters_code%.%original_file_name%
            ignore:
              - /**/%two_letters_code%.%original_file_name%

2.  Connect your GitHub repository

    In order for Crowdin to manage translations, you need to somehow push the
    translation sources from GitHub to Crowdin. Crowdin provides **two different
    connection options**, which are described below.

    ..  accordion::
        :name: crowdinConnectionAccordion

        ..  accordion-item:: Option A: Use the Crowdin <> GitHub integration
            :name: crowdinGitHubIntegration
            :header-level: 4

            ..  rst-class:: bignums

                1.  Configure the GitHub integration

                    In the Crowdin project settings, go to the Integrations tab and click
                    on the button "Browse Integrations", then choose "GitHub". Follow the
                    instructions to connect your GitHub repository to Crowdin.

                    Once installed, the Integrations tab will show the GitHub integration
                    with a button to "Set Up Integration". Click on it and choose the mode
                    "Source and translation files mode".

                    At this point, Crowdin will request additional permissions to access
                    your repository. You should accept the default permissions and click
                    on the "Authorize crowdin" button.

                    Then follow the instructions to configure the integration:

                    #.  Select the repository from the list of your GitHub repositories.
                    #.  Select the branch to use for synchronization (usually ``main`` or
                        ``master``). When ticking the branch, Crowdin will suggest a
                        "Service Branch Name" ``l10n_main`` (or ``l10n_master``), which
                        is the branch where Crowdin will push the translations. You can
                        keep the default value.
                    #.  Click the pencil icon next to the Service Branch Name to edit
                        configuration.
                    #.  When asked for the Configuration file name, change it from
                        ``crowdin.yml`` to ``.crowdin.yml`` and click "Continue". This
                        will effectively use the configuration we created in Step 1 and
                        ensure that everything is properly configured for your TYPO3
                        extension.
                    #.  Click the "Save" button to save the configuration.
                    #.  Back to the main GitHub integration page, you should see a circled
                        checkmark next to the Service Branch Name, indicating that the
                        integration is correctly set up.
                    #.  Ensure the checkbox "One-time translation import after the branch
                        is connected" is ticked.
                    #.  Do not tick the checkbox "Push Sources" as the sources are already
                        in the repository and changes are managed within the extension
                        repository **and not in Crowdin**.
                    #.  Click the "Save" button to save the configuration of the integration.

                2.  Import existing translations

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

        ..  accordion-item:: Option B: Create a GitHub workflow
            :name: crowdinGitHubWorkflow
            :header-level: 4

            When working with GitHub Actions, you can easily integrate the
            `Crowdin GitHub Action <https://github.com/marketplace/actions/crowdin-action>`__
            into your CI workflow.

            ..  rst-class:: bignums

                1.  Configure GitHub secrets

                    First, add the following GitHub secrets to your GitHub repository:

                    `CROWDIN_PROJECT_ID`
                        Project ID, can be found in **project settings** when
                        navigating to :guilabel:`Tools > API`.
                    `CROWDIN_PERSONAL_TOKEN`
                        API key used for authentication at Crowdin, can be
                        generated in **personal settings** at
                        :guilabel:`API > Personal Access Tokens`.

                    ..  tip::
                        When creating a personal access token in Crowdin, you will need to select some scopes.
                        For this workflow, set at least the following basic `Project` scopes:

                        *   **Projects (List, Get, Create, Edit)**: `Read Only`
                        *   **Translation Status**: `Read Only`
                        *   **Source files & strings**: `Read and Write`
                        *   **Translations**: `Read and Write`

                2.  Create GitHub workflow

                    Now create a new GitHub workflow :file:`crowdin.yaml`:

                    ..  literalinclude:: _codesnippets/_crowdin.yaml
                        :caption: EXT:my_extension/.github/workflows/crowdin.yaml

                    ..  important::

                        Make sure to configure a Crowdin branch name using the
                        `crowdin_branch_name` configuration option of the GitHub
                        action. Otherwise, translations are delivered incomplete
                        by TYPO3's Crowdin Bridge.

                    ..  seealso::

                        For more information about available configuration options,
                        consult the `official GitHub action documentation <https://github.com/marketplace/actions/crowdin-action>`__.

                3.  Push sources

                    For each push in your `main` branch, the workflow will now
                    transfer all your translation sources to Crowdin.

Happy translating!

..  tip::
    Checkout the :ref:`crowdin-faq` for solutions to common pitfalls.
