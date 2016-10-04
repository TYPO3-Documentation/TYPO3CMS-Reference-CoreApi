.. include:: ../Includes.txt

.. _database:

Database Access
===============

Database queries in TYPO3 are done with an API based on
`doctrine-dbal <http://www.doctrine-project.org/projects/dbal.html>`__.
The API is provided by the system extension `core` which is always loaded and
thus always available.

Doctrine-dbal is feature rich. Drivers for various target systems enable
TYPO3 to run on a long list of `ANSI SQL` compatible `DBMS`. If used properly,
queries created with this API are translated to the specific database engine by
doctrine without an extension developer taking care of that specifically.

The API provided by the core is basically a pretty small and lightweight facade
in front of `doctrine-dbal` that adds some convenient methods as well as some
`TYPO3 CMS` specific sugar. The facade additionally provides methods to retrieve
specific connection objects per configured database connection based on the table
that is queried. This enables instance administrators to configure different database
engines for different tables while this is transparent for extension developers.

.. note::

   `doctrine-dbal` has been introduced with TYPO3 CMS version 8 and substitutes the
   old API based on `$GLOBALS['TYPO3_DB']`. Extension authors are encouraged to switch
   away from TYPO3_DB to the new API. A dedicated chapter helps with typical migration
   questions. With database abstraction being built in within `doctrine-dbal` the old and
   optional extensions `dbal` and `adodb` are obsolete.


.. note::

   Doctrine is a two-fold project with `dotrine-dbal` being the low-level database
   abstraction and query building interface to specific database engines, while
   `doctrine-orm` is a high-level object relational mapping on top of `doctrine-dbal`.
   The TYPO3 CMS core only implemented the dbal part, `doctrine-orm` is neither required nor used
   at the time of this writing.


.. toctree::
   :maxdepth: 6
   :titlesonly:
   :glob:

   Configuration/Index
   BasicCrud/Index
   ClassOverview/Index
   ConnectionPool/Index
   QueryBuilder/Index
   Connection/Index
   ExpressionBuilder/Index
   RestrictionBuilder/Index
   Statement/Index
   Migration/Index
   TipsAndTricks/Index