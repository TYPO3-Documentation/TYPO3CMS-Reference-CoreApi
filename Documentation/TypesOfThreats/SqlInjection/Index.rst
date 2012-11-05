.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _sql-injection:

SQL injection
^^^^^^^^^^^^^

With SQL injection the attacker tries to submit modified SQL
statements to the database server in order to get access to the
database. This could be used to retrieve information such as customer
data or user passwords or even modify the database content such as
adding administrator accounts to the user table. Therefore it is
necessary to carefully analyze and filter any parameters that are used
in a database query.

