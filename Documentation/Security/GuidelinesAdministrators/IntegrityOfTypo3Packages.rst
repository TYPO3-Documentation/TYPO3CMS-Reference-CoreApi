:navigation-title: Code Integrity

..  include:: /Includes.rst.txt
..  _security-integrity-packages:

===============================
Verify integrity of TYPO3 code
===============================

Ensuring that the TYPO3 source code has not been tampered with is very important
for security reasons. TYPO3 can either be installed via Composer or by downloading
a prebuilt package. Each method requires different integrity checks.

..  _security-integrity-packages-composer:

Composer-based installations
============================

When using Composer, TYPO3 and its dependencies are downloaded directly by
Composer from trusted sources such as `packagist.org` and `packages.typo3.org`.

To ensure source integrity:

-   Use official TYPO3 packages (for example :composer:`typo3/cms-base-distribution`)
-   Commit the :file:`composer.lock` file to track versions and sources
-   Keep Composer and your system's trusted certificate store (CA certificates)
    up to date to ensure secure HTTPS connections when downloading packages.

Composer ensures a secure and verifiable dependency management workflow. It is
recommended to run Composer locally or in a
`CI pipeline <https://docs.typo3.org/permalink/t3coreapi:ci-cd-for-typo3-projects>`_,
and `deploy <https://docs.typo3.org/permalink/t3coreapi:deployment>`_ only the
prepared files - including the :directory:`vendor/` directory -
to the production environment.

..  _security-integrity-packages-classic:

Classic (non-Composer) installations
====================================

If installing TYPO3 via a downloaded archive (ZIP, tar.gz), verify the
SHA2-256 checksum before extracting. Only download from the official site:
`get.typo3.org <https://get.typo3.org>`_.

For details, see: `TYPO3 release integrity
<https://docs.typo3.org/permalink/t3coreapi:release-integrity>`_

Avoid vendor-provided or pre-installed packages unless you fully trust their
source.
