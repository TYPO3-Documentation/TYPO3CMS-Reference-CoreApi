:navigation-title: Mass Approval

..  include:: /Includes.rst.txt
..  index::
    Crowdin; Mass Approval
    Translations; Approval
..  _crowdin-mass-approval:

==============
Mass Approval
==============

After :ref:`importing existing translations <crowdin-extension-integration>` into
Crowdin, they need to be explicitly approved before becoming available for export.

This page provides a PHP implementation for programmatically approving translations
via the Crowdin API.

..  contents::
    :local:

Crowdin API Workflow
====================

The mass approval process follows these steps:

#.  Retrieve project metadata to get available languages
#.  List all files in the Crowdin project
#.  For each file, retrieve all source strings (once per file)
#.  For each string, iterate through target languages
#.  Approve unapproved translations using the Approvals API

API Endpoints
-------------

..  code-block:: text

    GET  /api/v2/projects/{projectId}
    GET  /api/v2/projects/{projectId}/files
    GET  /api/v2/projects/{projectId}/strings?fileId={fileId}
    GET  /api/v2/projects/{projectId}/translations?stringId={stringId}&languageId={languageId}
    POST /api/v2/projects/{projectId}/approvals

Authentication
--------------

All API requests require a Personal Access Token:

..  code-block:: bash

    Authorization: Bearer YOUR_API_TOKEN

Generate tokens at: https://crowdin.com/settings#api-key

PHP Implementation
==================

..  versionadded:: 13.0
    The following script requires **PHP 8.4+** and uses modern features:
    readonly classes, constructor property promotion, arrow functions, and enums.

The following script demonstrates mass approval using the Crowdin API v2:

..  literalinclude:: _codesnippets/crowdin_mass_approve.php
    :caption: crowdin_mass_approve.php
    :language: php

Usage
-----

..  code-block:: bash

    # Set API token (leading space prevents saving to shell history)
     export CROWDIN_TOKEN="your_api_token_here"

    # Approve all translations in project
    php crowdin_mass_approve.php 12345

    # Approve translations for specific language only
    php crowdin_mass_approve.php 12345 de

Progress Indicators
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

Best Practices
==============

Error Handling
--------------

The script includes robust error handling:

*   Errors are written to STDERR (not STDOUT)
*   Failed approvals are logged with full context (file, string, language, translation IDs)
*   Empty API responses are handled gracefully (returns empty array)
*   Network failures are caught and reported

Validation
----------

Before mass approval:

#.  Verify translations are complete and accurate
#.  Check for placeholder consistency (e.g., ``%s``, ``{variable}``)
#.  Validate translations don't contain English source text
#.  Review automatic translations from machine translation services

Security Considerations
=======================

..  warning::
    Mass approval bypasses the normal translation review workflow. Use with
    caution and ensure translations are validated before approval.

*   **API Token Security**: Store API tokens securely, never commit to version
    control. Use environment variables.
*   **Access Control**: Use tokens with minimal required permissions
*   **Audit Logging**: The script logs all failed approval operations with
    full context for accountability
*   **Quality Assurance**: Implement pre-approval validation to prevent approval
    of invalid translations

Alternatives
============

Crowdin Web Interface
---------------------

For smaller projects, manual approval via Crowdin's web interface may be more
appropriate:

#.  Navigate to project in Crowdin
#.  Select language
#.  Open the Editor in **side-by-side view**
#.  Use the bulk actions menu to approve all strings for the current language
#.  Alternatively, use batch operations to selectively approve multiple translations

See Also
========

*   :ref:`crowdin-extension-integration` - Integrate extensions with Crowdin
*   :ref:`crowdin-workflow` - Complete Crowdin translation workflow
*   `Crowdin API Documentation <https://developer.crowdin.com/api/v2/>`__
