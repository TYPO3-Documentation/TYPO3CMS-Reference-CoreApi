.. include:: /Includes.rst.txt
.. index:: ! Testing
.. _testing:

=======
Testing
=======


In TYPO3, we're taking testing serious: When the Core Team releases a new TYPO3 version, they want
to make sure it does not come with evil regressions (things that worked and stop working after update).
This is especially true for patch level releases. There are various measures to ensure the system does not
break: The patch review process is one, testing is another important part and there is more. With the
high flexibility of the system it's hard to test "everything" manually, though. The TYPO3 core thus has
a long history of automatic testing - some important steps are outlined in a dedicated chapter below.

With the continued improvements in this area an own testing framework has been established over the
years that is not only used by the TYPO3 core, but can be used by extension developers or entire
TYPO3 projects as well.

This chapter goes into details about automatic testing: Writing, maintaining and running them in
various scopes. Have fun.


.. toctree::
    :maxdepth: 1
    :titlesonly:

    History
    CoreTesting
    ExtensionTesting
    ProjectTesting
    WritingUnit
    WritingFunctional
    WritingAcceptance
    Faq
