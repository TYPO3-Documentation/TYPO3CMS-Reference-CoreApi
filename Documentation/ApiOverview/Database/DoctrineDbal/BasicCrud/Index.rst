..  include:: /Includes.rst.txt
..  index::
    Database; CRUD
    Database; Create, read, update, and delete operations
..  _database-basic-crud:
..  _cgl-database-access:

========================================================
Basic create, read, update, and delete operations (CRUD)
========================================================

This section provides a list of basic usage examples of the query API. This is
just a starting point. Details about the single methods can be found in the
following chapters, especially :ref:`QueryBuilder <database-query-builder>` and
:ref:`Connection <database-connection>`.

All examples use :ref:`dependency injection <DependencyInjection>` to provide
the :ref:`ConnectionPool <database-connection-pool>` in the classes.


.. contents:: **Table of Contents**
   :local:


..  index:: Database; INSERT

Insert a row
============

A direct insert into a table:

..  literalinclude:: _MyInsertRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyInsertRepository.php

This results in the following SQL statement:

..  code-block:: sql

    INSERT INTO `tt_content` (`pid`, `bodytext`)
        VALUES ('42', 'ipsum')


.. index:: Database; SELECT

.. _database-select:

Select a single row
===================

Fetching a single row directly from the :sql:`tt_content` table:

..  literalinclude:: _MySelectRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MySelectRepository.php

Result in :php:`$row`:

..  code-block:: none

    array(3 items)
       uid => 4 (integer)
       pid => 35 (integer)
       bodytext => 'some content' (12 chars)

The engine encloses field names in quotes, adds default TCA restrictions such as
:sql:`deleted=0`, and prepares a query to be executed with this final statement:

..  code-block:: sql

    SELECT `uid`, `pid`, `bodytext`
        FROM `tt_content`
        WHERE (`uid` = '4')
            AND ((`tt_content`.`deleted` = 0)
            AND (`tt_content`.`hidden` = 0)
            AND (`tt_content`.`starttime` <= 1669838885)
            AND ((`tt_content`.`endtime` = 0) OR (`tt_content`.`endtime` > 1669838885)))

..  note::
    The default restrictions :sql:`deleted`, :sql:`hidden`, :sql:`startime` and
    :sql:`endtime` based on the :ref:`TCA setting of a table <t3tca:ctrl>` are
    only applied to :sql:`select()` calls, they are **not** added for
    :sql:`delete()` or other query types.


Select multiple rows with some "where" magic
--------------------------------------------

Advanced query using the :php:`QueryBuilder` and manipulating the default
restrictions:

..  literalinclude:: _MyQueryBuilderSelectRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyQueryBuilderSelectRepository.php

Result in :php:`$rows`:

..  code-block:: none

    array(2 items)
        0 => array(3 items)
            uid => 4 (integer)
            pid => 35 (integer)
            bodytext => 'ipsum' (5 chars)
        1 => array(3 items)
            uid => 366 (integer)
            pid => 13 (integer)
            bodytext => 'lorem' (5 chars)

The executed query looks like this:

..  code-block:: sql

    SELECT `uid`, `pid`, `bodytext`
        FROM `tt_content`
        WHERE ((`bodytext` = 'lorem') OR (`uid` = 4))
            AND (`tt_content`.`deleted` = 0)


.. index:: Database; UPDATE

Update multiple rows
====================

..  literalinclude:: _MyUpdateRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyUpdateRepository.php

The executed query looks like this:

..  code-block:: sql

    UPDATE `tt_content` SET `bodytext` = 'ipsum'
        WHERE `bodytext` = 'lorem'

..  tip::
    You can also use the :php:`QueryBuilder` to create more complex update
    queries. For examples, see the :ref:`QueryBuilder chapter
    <database-query-builder-update-set>`.


Delete a row
============

..  literalinclude:: _MyDeleteRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyDeleteRepository.php

The executed query looks like this:

..  code-block:: sql

    DELETE FROM `tt_content`
        WHERE `uid` = '4711'
