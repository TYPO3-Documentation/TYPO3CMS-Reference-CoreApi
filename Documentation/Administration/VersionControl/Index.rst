:navigation-title: Version Control (Git)

..  include:: /Includes.rst.txt

..  _version-control:

==========================================
Version control of TYPO3 projects with Git
==========================================

Using Git for version control in TYPO3 projects helps ensure consistent
collaboration, transparent change tracking, and safer deployments. It allows
teams to keep a complete history of changes, isolate new features, and revert
to a known state when needed.

Even if you are working alone — as a freelancer or solo developer — Git is
highly valuable. It acts as a time machine for your project, allowing you to:

-   Experiment with confidence by branching and reverting
-   Document and understand your progress over time
-   Sync work between devices or back it up to the cloud
-   Undo mistakes and recover lost files easily
-   Share code with clients, agencies, or collaborators when needed

Whether you are building a quick prototype or maintaining a long-term
client project, version control with Git adds safety, flexibility, and
professionalism to your workflow.

.. contents:: Table of contents
..  _version-control-quick-start:

Quick Start: Add a TYPO3 project to Git
=======================================

This step-by-step guide explains how to add a new or existing TYPO3 project
to a Git repository. It includes instructions for safely setting up a
`.gitignore` and avoiding the accidental inclusion of credentials or
environment-specific files.

Depending on your installation method, some files differ. Use the relevant tab
below to identify what to include in version control.

..  tabs::

    ..  group-tab:: Composer-based

        1.  Create or review your :file:`.gitignore`

            Use the example from the official GitLab TYPO3 template:
            https://gitlab.com/gitlab-org/project-templates/typo3-distribution/-/blob/main/.gitignore

            Make sure it includes:

            -   :file:`.env`
            -   :file:`auth.json`
            -   :file:`/var/`
            -   :file:`/vendor/`
            -   :file:`/public/fileadmin/`
            -   :file:`/public/typo3temp/`

        2.  Double-check for credentials and secrets

            -   Do not commit passwords or API keys in:

                -   :file:`config/system/settings.php`
                -   :file:`config/system/additional.php`
                -   :file:`config/sites/my_site/config.yaml` and
                    :file:`config/sites/my_site/settings.yaml`

            -   Use environment variables or include untracked files
                (see :ref:`version-control-credentials`)

        3.  Add a `.env.example` file to document required variables

            ..  code-block:: bash

                cp .env .env.example

        4.  Add the relevant project files

            ..  code-block:: bash

                git add .gitignore
                git add composer.json composer.lock
                git add config/
                git add packages/
                git add public/index.php public/.htaccess public/typo3/

    ..  group-tab:: Classic mode (non-Composer)

        1.  Create a :file:`.gitignore`

            Use the example in :ref:`Example .gitignore <version-control-gitignore-example>`.

            Typical exclusions:

            -   :file:`typo3temp/`
            -   :file:`typo3_src/`
            -   :file:`fileadmin/`
            -   :file:`.env`

        2.  Check for credentials

            -   :file:`typo3conf/system/settings.php`
            -   :file:`typo3conf/system/additional.php`
            -   :file:`typo3conf/sites/my_site/config.yaml` and
                :file:`typo3conf/sites/my_site/settings.yaml`

        3.  Add the selected project files

            ..  code-block:: bash

                git add .gitignore
                git add typo3conf/ext/my_sitepackage
                git add typo3conf/ext/my_custom_extension
                git add .htaccess
                git add robots.txt

        See also: `Which TYPO3 directories and files should be kept under
        version control <https://docs.typo3.org/permalink/t3coreapi:version-control-commit>`_.

These steps apply to **all TYPO3 projects**, no matter the installation type:

1.  Initialize the Git repository

    ..  code-block:: bash

        git init

2.  Make your initial commit

    ..  code-block:: bash

        git commit -m "Initial commit: My TYPO3 project"

3.  Add a remote repository and push (optional)

    If you are using a
    `Git hosting platform <https://docs.typo3.org/permalink/t3coreapi:version-control-platforms>`_,
    push your changes there:

    ..  code-block:: bash

        git remote add origin git@example.com:user/project.git
        git push -u origin main


..  _version-control-platforms:

Git hosting platforms (GitHub, GitLab, Gerrit, Bitbucket, ..)
=============================================================

A **Git hosting platform** is a service that stores your Git repositories
remotely and allows collaboration with others. It also provides tools such
as web interfaces, access control, issue tracking, continuous integration
(CI), and backups.

Using a hosting platform is recommended even for solo projects, as it makes
it easier to:

-   Share your code with others (team members, clients, ...)
-   Back up your work to the cloud
-   Track issues, bugs, and tasks
-   Set up CI/CD pipelines for automated testing and deployment

All Git hosting platforms are supported. The following are commonly used:

-   `GitHub <https://github.com/>`_ – Popular for open-source and private projects
-   `GitLab <https://gitlab.com/>`_ – Offers CI/CD and self-hosting options
-   `Bitbucket <https://bitbucket.org/>`_ – Integrates with Atlassian tools
-   `Gitea <https://gitea.io/>`_ – Lightweight, open-source, self-hosted platform
-   `Codeberg <https://codeberg.org/>`_ – Free and open-source Git hosting
-   `Gerrit <https://www.gerritcodereview.com/>`_ – Git server with built-in
    code review workflow; used by the TYPO3 Core team

..  _version-control-commit:

Which TYPO3 directories and files should be kept under version control
======================================================================

..  _version-control-commit-always:

Directories and files to always commit
--------------------------------------

..  tabs::

    ..  group-tab:: Composer-based

        -   :file:`.gitignore`
        -   :file:`composer.json`, `composer.lock`
        -   :path:`config/sites` – `Site handling <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_
        -   :file:`config/system/settings.php` – `System configuration files <https://docs.typo3.org/permalink/t3coreapi:configuration-files>`_
        -   :path:`packages/` – Custom extensions and site packages

    ..  group-tab:: Classic mode (non-Composer)

        -   :file:`.gitignore`
        -   :path:`typo3conf/sites` – `Site handling <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_
        -   :file:`typo3conf/system/settings.php` – `System configuration files <https://docs.typo3.org/permalink/t3coreapi:configuration-files>`_
        -   :path:`typo3conf/ext/my_sitepackage` – Custom site packages
        -   :path:`typo3conf/ext/my_custom_extension` – Custom extensions

..  _version-control-platforms-optional:

Optional to Commit
------------------

Depending on project needs, you may include:

-   Docker and CI/CD config – :file:`.gitlab-ci.yml`, :file:`docker-compose.yml`, ...
-   Files needed for testing like :file:`.php-cs-fixer.dist.php`,
    :file:`phpstan.neon`, :file:`runTests.sh` etc.
-   Build folders containing sources for asset building like scss sources,
    typescript sources, etc. never commit :php:`node_modules`, these files are
    managed by gulp or vite.
-   Files used during local development like :file:`.editorconfig`, :file:`Makefile`
    and :file:`ddev/config.yaml`

Additional files may be versioned depending on your project requirements and
installation method:

..  tabs::

    ..  group-tab:: Composer-based

        -   :file:`config/system/additional.php` – Depending on how this file
            should be managed to override server settings.
        -   :file:`public/.htaccess`
        -   :file:`public/robots.txt`

    ..  group-tab:: Classic mode (non-Composer)

        -   :file:`typo3conf/system/additional.php` – Depending on how this file
            should be managed to override server settings.
        -   :file:`.htaccess`
        -   :file:`robots.txt`

        Information on which versions exactly have been installed - or:

        -   :file:`index.php`
        -   :path:`typo3conf/ext/` – All installed extensions (So the project
            can be fully restored from the Git repository without needing
            external packages or configuration.)
        -   :path:`typo3conf/l10n/` – If you also want to keep automatic
            localizations under version control
        -   :path:`typo3conf/PackageStates.php` – To determine which of the
            loaded extensions are installed
        -   :path:`typo3/sysext/` – The TYPO3 Core (So a project can
            be rebuild in from the Git alone)
        -   :file:`typo3/install.php`


..  _version-control-platforms-never:

Directories and files to never commit
-------------------------------------

..  tabs::

    ..  group-tab:: Composer-based

        -   `public/fileadmin/` – User-uploaded files, these are managed by
            `File abstraction layer (FAL) <https://docs.typo3.org/permalink/t3coreapi:fal-introduction>`_
        -   `public/typo3temp/` – Temporary cache files
        -   `var/` – Cache, sessions, and lock files, managed by TYPO3
        -   `vendor/` – Managed by Composer
        -   `.env` – Environment-specific variables and secrets

    ..  group-tab:: Classic mode (non-Composer)

        -   `fileadmin/` – User-uploaded files, these are managed by
            `File abstraction layer (FAL) <https://docs.typo3.org/permalink/t3coreapi:fal-introduction>`_
        -   `typo3temp/` – Temporary cache files, sessions, and lock files, managed by TYPO3

..  _version-control-gitignore-example:

Example `.gitignore`
====================

A :file:`.gitignore` file tells Git which files and folders to ignore when committing
to the repository. This helps prevent unnecessary or sensitive files (like cache,
uploads, or environment configs) from being tracked.

The :file:`.gitignore` file should be placed in the root directory of your TYPO3
project (usually alongside :file:`composer.json` or :file:`typo3conf/`). Its contents
can vary depending on whether you use a Composer-based setup or a
classic (non-Composer) structure.

For more on how :file:`.gitignore` works, see the official Git documentation:
https://git-scm.com/docs/gitignore

..  tabs::

    ..  group-tab:: Composer-based

        For Composer-based projects, you can use the `.gitignore` from the official
        GitLab TYPO3 Project Template as a solid starting point.

        .. literalinclude:: _codesnippets/_GitIgnoreComposer.txt
            :caption: project_root/.gitignore
            :language: plaintext
            :linenos:

        ..  seealso::

            The official GitLab TYPO3 Project Template includes a preconfigured
            `.gitignore` file that covers most Composer-based setups. You can view
            it here:

            https://gitlab.com/gitlab-org/project-templates/typo3-distribution/-/blob/main/.gitignore

    ..  group-tab:: Classic mode (non-Composer)

        .. literalinclude:: _codesnippets/_GitIgnoreClassic.txt
            :caption: project_root/.gitignore
            :language: plaintext
            :linenos:
..  note::

    Some development tools such as `DDEV <https://ddev.readthedocs.io/>`_
    may automatically create `.gitignore` files inside specific
    subdirectories (e.g., `public/`, `.ddev/`, or `vendor/`). These are
    usually intended to prevent tool-specific or temporary files from
    being committed. You can customize or remove them if needed, but
    be aware of their purpose before doing so.

..  _version-control-credentials:

Avoid committing credentials to Git
===================================

..  warning::

    Be very careful not to commit sensitive information such as passwords,
    API keys, access tokens, or database credentials to your Git repository.

Examples of files that often contain secrets:

-   :file:`.env` – Environment-specific variables
-   :file:`auth.json` – Composer credentials
-   :file:`config/system/settings.php` – TYPO3 system-level configuration;
    may include database credentials, encryption key, install tool password,
    and global extension settings.
-   :file:`config/system/additional.php` TYPO3 system-level configuration
    overrides
-   :file:`config/sites/some_site/config.yaml` Solr credentials, credentials
    from other third party extension not using settings yet.
-   :file:`config/sites/some_site/settings.yaml` – Site-level configuration
    for individual extensions (for example CRM, analytics, etc.); can
    contain site-specific tokens or secrets.

..  _version-control-credentials-best-practice:

Best practices to avoid accidentally committing credentials
-----------------------------------------------------------

-   Add secret files to your :file:`.gitignore` before running :command:`git add`
-   Use environment variables instead of hardcoded credentials
-   Split config files: version the structure (e.g., `settings.php`) but load secrets
    from untracked overrides (for example `credentials.php`)
-   Use `.env.example` to document required environment variables, and keep the real
    `.env` excluded
-   You can also use an extension like :composer:`helhum/dotenv-connector` to
    manage secrets via environment variables.

..  _version-control-credentials-best-practice-additional-php:

Credentials in the settings.php or additional.php
-------------------------------------------------

For example, you could keep all credentials in a file called
:file:`config/system/credentials.php` and include this file into your
:file:`config/system/additional.php` if present:

..  literalinclude:: _codesnippets/_additional.php
    :caption: project_root/config/system/additional.php

..  literalinclude:: _codesnippets/_credentials.php
    :caption: config/system/credentials.php (Add to `.gitignore`, Do not commit to Git!!!)

..  _version-control-credentials-best-practice-site-config:

Credentials in the site configuration or settings
-------------------------------------------------

It is also possible that the `site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling>`_
`Site setting <https://docs.typo3.org/permalink/t3coreapi:sitehandling-settings>`_
files contain credentials (for example Solr credentials). You can use
environment variables directly in YAML files:

..  code-block:: yaml
    :caption: project_root/config/sites/example/config.yaml

    base: 'https://www.example.org/'

    # ...

    solr_host_read: '%env("SOLR_USER")%'
    solr_password_read: '%env("SOLR_PASSWORD")%'

..  code-block:: bash
    :caption: project_root/.env  (Add to `.gitignore`, Do not commit to Git!!!)

    SOLR_USER=my-solr-user
    SOLR_PASSWORD=secret

..  _version-control-credentials-accident:

If you accidentally committed credentials
-----------------------------------------

1.  **Change them immediately** (reset API tokens or database passwords)
2.  Remove the file from Git history:

    ..  code-block:: bash

        git rm --cached .env
        echo ".env" >> .gitignore
        git commit -m "Remove .env and ignore it"

3.  If pushed to a public repo, consider using tools like
    `BFG Repo-Cleaner <https://rtyley.github.io/bfg-repo-cleaner/>`_ or
    `git filter-repo <https://github.com/newren/git-filter-repo>`_ to fully remove
    secrets from history.

..  warning::

    Secrets committed to a public repository should be considered compromised,
    even if deleted afterward. Rotate them as soon as possible.
