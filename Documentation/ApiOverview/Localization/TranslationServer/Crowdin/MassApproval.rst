:navigation-title: Bulk approval

..  include:: /Includes.rst.txt
..  index::
    Crowdin; Bulk approval
    Translations; Approval
..  _crowdin-mass-approval:

========================
Bulk approval on Crowdin
========================

After :ref:`importing existing translations <crowdin-extension-integration>` into
Crowdin, they must be approved before they become available for export.

The `Crowdin CLI for TYPO3 <https://docs.typo3.org/permalink/t3coreapi:crowdin-cli>`_
approves translations in bulk from the command line: all suggestions of one
user, all suggestions below a file path, or a list of translation IDs. A dry
run shows beforehand what would be approved, and approvals made by mistake can
be revoked. For a guided review, the tool shows the pending suggestions in
chunks and asks which of them to approve.

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

*   :ref:`Integrate Crowdin in your extension <crowdin-extension-integration>` —
    Integrate extensions with Crowdin
*   :ref:`From new Crowdin translations to the installation <crowdin-workflow>`
    — Complete Crowdin translation workflow
*   `Crowdin API Documentation <https://developer.crowdin.com/api/v2/>`__
