..  include:: /Includes.rst.txt

..  _cgl-modeling-cross-cutting-concerns:
..  _cgl-php-architecture:

================
PHP Architecture
================

This chapter aims to give developers some ideas and practices at hand
when PHP architectural decisions have to be taken. Result should be a
understanding of some thoughts behind and a harmonization of solutions
found in the TYPO3 Core and maybe in third-party extensions. It
should help reviewers to evaluate solutions and how they stick to the
main code separation principles the Core tries to follow. The document
should help developers to train their architectural skills and to rate
easier which pattern matches a given problem to improve code quality
and exchangeability.

These following sections also address cross-cutting concerns, which are
problems that have to be solved at multiple, distinct places within the
system that have no further connection to each other. It is a cross-class
hierarchy and maybe cross-extension problem that can and should not
be solved with class abstractions.


..  toctree::
    :maxdepth: 1
    :titlesonly:

    Services
    StaticMethods
    Traits
    WorkingWithExceptions
