:navigation-title: CI/CD Automation

..  include:: /Includes.rst.txt
..  _ci-cd-for-typo3-projects:

==============================================
CI/CD: Automatic deployment for TYPO3 Projects
==============================================

**Continuous Integration (CI)** and **Continuous Deployment/Delivery (CD)**
are development practices that automate the process of building, testing,
and deploying code. Implementing CI/CD for TYPO3 projects ensures higher
quality releases, faster feedback loops, and lower risk of introducing bugs.

..  contents::

..  _why-ci-cd-for-typo3:

Why CI/CD for TYPO3?
====================

TYPO3 is a powerful, enterprise-level CMS written in PHP. TYPO3 projects
often involve custom extensions, configuration management (TypoScript, YAML config),
and complex deployment workflows. Manual deployment increases the risk of
human error, environment inconsistencies, and delayed releases. CI/CD
automates these concerns.

..  _ci-cd-common-stages:

Common CI/CD Stages in TYPO3 Projects
=====================================

..  _ci-cd-code-quality-checks:

Code Quality Checks
-------------------

*   **PHP Linting** (for example, :bash:`php -l`)
*   `Code style tests and fixing <https://docs.typo3.org/permalink/t3coreapi:testing-projects-configuration-cs>`_
*   **Static Analysis** (for example `PHPstan <https://docs.typo3.org/permalink/t3coreapi:testing-projects-configuration-phpstan>`_ or Psalm)
*   Linting of other used formats like `TypoScript <https://github.com/martin-helmich/typo3-typoscript-lint>`_, XML, and YAML.

..  _ci-cd-unit-functional-testing:

Unit and Functional Testing
---------------------------

*   `Unit tests <https://docs.typo3.org/permalink/t3coreapi:testing-writing-unit>`_
*   `Functional tests <https://docs.typo3.org/permalink/t3coreapi:testing-writing-functional>`_
*   `Acceptance tests <https://docs.typo3.org/permalink/t3coreapi:testing-writing-acceptance>`_

..  _ci-cd-building-artifacts:

Building Artifacts
------------------

*   Installing required extensions and other PHP packages via Composer
*   Compile frontend assets (e.g., SCSS, JavaScript) using tools like
    Webpack, Gulp or Vite.

..  _ci-cd-deployment:

Deployment
----------

*   **File Synchronization**: Deploy code and assets using tools like `Rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_,
    `Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_,
    or Git-based workflows.
*   **Database Migrations**: Run database migrations using TYPO3’s
    `vendor/bin/typo3 extension:setup` or
    `vendor/bin/typo3 database:updateschema` if :composer:`helhum/typo3-console`
    is installed.
*   **Cache Clearing**: Clear TYPO3 caches
    (`vendor/bin/typo3 cache:flush`).

..  _ci-cd-environment-configuration:

Environment configuration
--------------------------

Manage environment-specific settings using
`.env / dotenv files <https://docs.typo3.org/permalink/t3coreapi:environment-dotenv>`_
or `Plain PHP configuration files <https://docs.typo3.org/permalink/t3coreapi:environment-phpconfig>`_.

..  _ci-cd-typical-tools:

Typical CI/CD Tools Used
------------------------

CI/CD Platforms
    `GitHub Actions <https://docs.typo3.org/permalink/t3coreapi:ci-cd-github>`_,
    `GitLab CI <https://docs.typo3.org/permalink/t3coreapi:ci-cd-gitlab>`_,
    `Jenkins <https://www.jenkins.io/>`_, or `CircleCI <https://circleci.com/>`_

Code Quality
    `PHP-CS-Fixer <https://docs.typo3.org/permalink/t3coreapi:testing-projects-configuration-cs>`_,
    `PHPstan <https://docs.typo3.org/permalink/t3coreapi:testing-projects-configuration-phpstan>`_,
    and `TypoScript-Lint <https://github.com/martin-helmich/typo3-typoscript-lint>`_

Testing
    `PHPUnit <https://phpunit.de/>`_ with the `TYPO3 Testing Framework <https://docs.typo3.org/permalink/t3coreapi:testing-writing-unit>`_

Build Tools
    Docker or Podman, Composer, Webpack, Gulp, or Vite

Deployment Tools
    `Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_,
    `Rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_, Helm, Ansible, GitOps


..  _ci-cd-plattforms:

CI/CD Platforms
===============

..  _ci-cd-gitlab:

Using GitLab CI
---------------

The `Official GitLab template for TYPO3 <https://docs.typo3.org/permalink/t3start:gitlab-template>`_
provides a predefined `.gitlab-ci.yml <https://gitlab.com/gitlab-org/project-templates/typo3-distribution/-/blob/main/.gitlab-ci.yml>`_
and a `Deployer recipe <https://docs.typo3.org/permalink/t3coreapi:deployer-gitlab>`_
that you can customize to your needs.

Even if you already set up your project you can find valuable examples there.

..  _ci-cd-github:

Using GitHub Actions
--------------------

.. code-block:: yaml

    name: TYPO3 CI/CD Pipeline

    on:
      push:
        branches: [ "main" ]

    jobs:
      build:
        runs-on: ubuntu-latest

        steps:
          - uses: actions/checkout@v4

          - name: Set up PHP
            uses: shivammathur/setup-php@v2
            with:
              php-version: '8.3'

          - name: Install Dependencies
            run: composer install --prefer-dist

          - name: Lint PHP
            run: find . -name "*.php" -exec php -l {} \;

          - name: Run PHPStan
            run: vendor/bin/phpstan analyse

          - name: Run PHPUnit Tests
            run: vendor/bin/phpunit

          - name: Deploy (Example)
            run: |
              ssh user@server 'cd /var/www/html && git pull && composer install \
              --no-dev && ./vendor/bin/typo3 cache:flush'


..  _ci-cd-best-practices:

Best practices during CI/CD
===========================

#.  **Version Control Everything**
        Include `composer.json`, `composer.lock`, `config/`, `packages`, and
        deployment scripts.

#.  **Use Environment Variables**
        Never hardcode environment-specific values.

#.  **Keep Builds Reproducible**
        Lock dependencies with `composer.lock`.

#.  **Automate Database Migrations**
        Apply migrations as part of the deployment step.

    #.  **Fail Fast**
            Ensure the pipeline stops on errors in quality checks or tests.

    #.  **Use Staging Environments**
            Test changes in staging before promoting to production.
