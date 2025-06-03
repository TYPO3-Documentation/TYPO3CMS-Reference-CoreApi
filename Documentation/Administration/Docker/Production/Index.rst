:navigation-title: In production

..  include:: /Includes.rst.txt
..  _docker-production:

===========================
Using Docker in production
===========================

..  include:: /Administration/Docker/Production/_Experimental.rst.txt

TYPO3 can be run in containers in production, but doing so requires a solid
understanding of Docker and system administration.

Running TYPO3 in Docker is **not plug-and-play**. You must account for
infrastructure-related topics such as security, data persistence, and update
strategies.

..  toctree::
    :caption: Topics
    :titlesonly:

    Distribution/Index
    Database/Index
    FilePermissions/Index

..  seealso::

    -   `Security Guidelines for TYPO3 System Administrators <https://docs.typo3.org/permalink/t3coreapi:security-administrators>`_
    -   `Docker deployment <https://docs.typo3.org/permalink/t3coreapi:docker-deployment>`_
    -   `Docker production best practices <https://docs.docker.com/develop/dev-best-practices/>`_
    -   `Docker security overview <https://docs.docker.com/engine/security/security/>`_
