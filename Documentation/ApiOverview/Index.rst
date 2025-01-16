.. include:: /Includes.rst.txt

..  _api:

=======
API A-Z
=======

The TYPO3 Core code serves a dual purpose: It functions both as an out-of-the-box
application and as a library providing APIs for extensions that enhance projects
with additional functionality.

The TYPO3 Core itself organizes its code into extensions as well, with the "core"
extension offering the majority of API classes. These classes are utilized by
other key extensions such as "frontend" and "backend". These three extensions
are mandatory for any TYPO3-based project, while others, like "scheduler,"
are optional.

This chapter focuses on the APIs primarily provided by these three essential
extensions.

TYPO3 APIs are primarily documented within the source code itself. Maintaining
documentation in multiple locations is impractical due to the frequent changes
in the codebase. This chapter highlights the most critical elements of the
API.

.. note::

   The source is the documentation! (General wisdom)

**Contents:**

..  toctree::
    :titlesonly:
    :glob:

    */Index
