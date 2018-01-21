.. include:: ../../Includes.txt


.. _cgl-modeling-cross-cutting-concerns:

Modeling Cross Cutting Concerns
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

A cross cutting concern we are talking about here is a problem that
has to be solved at multiple, distinct places within the system that
have no further connection to each other. It is a cross class-hierarchy
and maybe cross-extension problem that can and should not be solved
with class abstractions.

.. toctree::
    :maxdepth: 1
    :titlesonly:
    :glob:

    StaticMethods
    Traits
    Services

