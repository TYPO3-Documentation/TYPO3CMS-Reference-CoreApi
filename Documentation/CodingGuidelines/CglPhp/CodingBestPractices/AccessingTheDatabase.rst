..  include:: /Includes.rst.txt
..  index:: pair: Coding guidelines; Database
..  _cgl-database-access:

======================
Accessing the Database
======================

The TYPO3 database should always be accessed using the :php:`QueryBuilder` of
Doctrine. The :ref:`ConnectionPool <database-connection-pool>` class should be
injected via :ref:`constructor injection <Constructor-injection>` and can then
be used to create a :ref:`QueryBuilder <database-query-builder>` instance:

..  literalinclude:: _AccessingTheDatabase/_MyTableRepository.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

See the :ref:`Database <database>` chapter for more details.
