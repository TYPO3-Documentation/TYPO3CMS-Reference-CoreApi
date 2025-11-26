:navigation-title: Mass approval

..  include:: /Includes.rst.txt
..  index::
    Crowdin; Mass approval
    Translations; Approval
..  _crowdin-mass-approval:

========================
Mass approval on Crowdin
========================

After :ref:`importing existing translations <crowdin-extension-integration>` into
Crowdin, they must be explicitly approved before becoming available for export.

This page provides a PHP implementation for programmatically approving translations
via the Crowdin API.

..  contents::
    :local:

..  _crowdin-mass-approval-workflow:

Crowdin API workflow
====================

The mass approval process follows these steps:

#.  Retrieve project metadata to get available languages.
#.  List all files in the Crowdin project.
#.  For each file, retrieve all source strings (once per file).
#.  For each string, iterate through target languages.
#.  Approve unapproved translations using the Approvals API.

..  _crowdin-mass-approval-api:

API endpoints
-------------

..  code-block:: text

    GET  /api/v2/projects/{projectId}
    GET  /api/v2/projects/{projectId}/files
    GET  /api/v2/projects/{projectId}/strings?fileId={fileId}
    GET  /api/v2/projects/{projectId}/translations?stringId={stringId}&languageId={languageId}
    POST /api/v2/projects/{projectId}/approvals

..  _crowdin-mass-approval-authentication:

Authentication
--------------

All API requests require a Personal Access Token:

..  code-block:: bash

    Authorization: Bearer YOUR_API_TOKEN

Generate tokens at: https://crowdin.com/settings#api-key

..  _crowdin-mass-approval-implementation:

PHP implementation
==================

..  versionadded:: 13.0
    The following script requires **PHP 8.4+** and uses modern features:
    readonly classes, constructor property promotion, arrow functions, and enums.

The following script demonstrates mass approval using the Crowdin API v2:

..  literalinclude:: _codesnippets/crowdin_mass_approve.php
    :caption: crowdin_mass_approve.php
    :language: php

..  _crowdin-mass-approval-implementation-usage:

Usage
-----

..  code-block:: bash

    # Set API token (leading space prevents saving to shell history)
     export CROWDIN_TOKEN="your_api_token_here"

    # Approve all translations in the project
    php crowdin_mass_approve.php 12345

    # Approve translations for a specific language only
    php crowdin_mass_approve.php 12345 de

..  _crowdin-mass-approval-implementation-progress:

Progress indicators
-------------------

During execution, the script outputs progress indicators:

*   **F** - Processing a new file
*   **S** - Processing a new string within the file
*   **L** - Processing a translation (language) for the string

Example output:

..  code-block:: text

    Processing: de, fr, es
    FSLLLSLLLFSLLSLLLFSLLLL...

    === Summary ===
    Approved: 234 | Skipped: 56 | Errors: 0

..  _crowdin-mass-approval-best-practices:

Best practices
==============

..  _crowdin-mass-approval-best-practices-error:

Error handling
--------------

The script includes robust error handling:

*   Errors are written to STDERR (not STDOUT).
*   Failed approvals are logged with full context (file, string, language, translation IDs).
*   Empty API responses are handled gracefully (returns an empty array).
*   Network failures are caught and reported.

..  _crowdin-mass-approval-best-practices-validation:

Validation
----------

Before mass approval:

#.  Verify that translations are complete and accurate.
#.  Check for placeholder consistency (e.g., ``%s``, ``{variable}``).
#.  Validate that translations do not contain English source text.
#.  Review automatic translations from machine translation services.

..  _crowdin-mass-approval-security:

Security considerations
=======================

..  warning::
    Mass approval bypasses the normal translation review workflow. Use with
    caution and ensure translations are validated before approval.

*   **API token security**: Store API tokens securely—never commit them to version
    control. Use environment variables.
*   **Access control**: Use tokens with the minimal required permissions.
*   **Audit logging**: The script logs all failed approval operations with
    full context for accountability.
*   **Quality assurance**: Implement pre-approval validation to prevent approval
    of invalid translations.

..  _crowdin-mass-approval-alternatives:

Alternatives
============

..  _crowdin-mass-approval-alternatives-web:

Crowdin web interface
---------------------

For smaller projects, manual approval via Crowdin's web interface may be more
appropriate:

#.  Navigate to the project in Crowdin.
#.  Select a language.
#.  Open the editor in **side-by-side view**.
#.  Use the bulk actions menu to approve all strings for the current language.
#.  Alternatively, use batch operations to selectively approve multiple translations.

..  _crowdin-mass-approval-see-also:

See also
========

*   :ref:`crowdin-extension-integration` — Integrate extensions with Crowdin
*   :ref:`crowdin-workflow` — Complete Crowdin translation workflow
*   `Crowdin API Documentation <https://developer.crowdin.com/api/v2/>`__
