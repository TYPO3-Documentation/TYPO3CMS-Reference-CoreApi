..  include:: /Includes.rst.txt
..  index:: TypoScript; Syntax
..  _typoscript:

==========
TypoScript
==========

This chapter describes the syntax of TypoScript. The TypoScript syntax
and its parser logic is mainly used in two different contexts: `Frontend TypoScript`
to configure frontend rendering and `TSconfig` to configure backend details
for backend users.

While the underlying TypoScript syntax is described in this chapter, both use cases
and their details are found in standalone manuals:

*   The :ref:`TypoScript Reference <t3tsref:start>` goes into details about the
    usage of TypoScript in the frontend.

*   The :ref:`TSconfig Reference <t3tsconfig:start>` goes into details about
    configuring the TYPO3 backend for backend users.

*   A quick kick start to frontend TypoScript is available at
    :ref:`TypoScript guide <t3tsref:guide>`.

.. note::

    The TypoScript parser has been rewritten with TYPO3 v12. The new implementation is
    more resilient and more performant. This chapter has been rewritten for TYPO3 v12.
    Some hints are given throughout the document where the new parser is more relaxed
    or more strict. Refer to
    `older versions <https://docs.typo3.org/m/typo3/reference-coreapi/11.5/en-us/Configuration/TypoScriptSyntax/Index.html>`__
    of this chapter when using TYPO3 versions older than v12. More details of changes implemented with the
    new parser can be found in this :doc:`ext_core:Changelog/12.0/Breaking-97816-TypoScriptSyntaxChanges`
    and this :doc:`ext_core:Changelog/12.0/Feature-97816-TypoScriptSyntaxImprovements`
    changelog entries.


**Table of Contents:**

.. toctree::
   :titlesonly:
   :glob:

   Introduction/Index
   Syntax/Index
   FrontendTypoScript/Index
   TSconfig/Index
   PhpApi/Index
   MythsFaq/Index
