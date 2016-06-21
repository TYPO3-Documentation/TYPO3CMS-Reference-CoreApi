.. include:: ../../../Includes.txt


.. _Database-Structure:

==================
Database structure
==================


.. highlight:: sql


.. _DB-table-sys_file:

sys\_file
=========

Table structure for table 'sys\_file'. *Note:*
'tstamp' is the update timestamp of the
database record, not of the file! ::

   CREATE TABLE sys_file (
      uid          int(11)     NOT NULL auto_increment,
      pid          int(11)     DEFAULT '0' NOT NULL,
      tstamp       int(11)     DEFAULT '0' NOT NULL,
      last_indexed int(11)     DEFAULT '0' NOT NULL,

      # management information
      missing      tinyint(4)  DEFAULT '0' NOT NULL,
      storage      int(11)     DEFAULT '0' NOT NULL,
      type         varchar(10) DEFAULT ''  NOT NULL,
      metadata     int(11)     DEFAULT '0' NOT NULL,

      # file info data
      identifier        text,
      identifier_hash   varchar(40)         DEFAULT ''  NOT NULL,
      folder_hash       varchar(40)         DEFAULT ''  NOT NULL,
      extension         varchar(255)        DEFAULT ''  NOT NULL,
      mime_type         varchar(255)        DEFAULT ''  NOT NULL,
      name              tinytext,
      sha1              tinytext,
      size              bigint(20) unsigned DEFAULT '0' NOT NULL,
      creation_date     int(11)             DEFAULT '0' NOT NULL,
      modification_date int(11)             DEFAULT '0' NOT NULL,

      PRIMARY KEY (uid),
      KEY sel01 (storage,identifier_hash),
      KEY folder (storage,folder_hash),
      KEY tstamp (tstamp),
      KEY lastindex (last_indexed),
      KEY sha1 (sha1(40))
   );


.. _DB-table-sys_file_collection:

sys\_file\_collection
=====================

Table structure for table 'sys\_file\_collection'::

   CREATE TABLE sys_file_collection (
      uid              int(11)     NOT NULL auto_increment,
      pid              int(11)     DEFAULT '0' NOT NULL,
      tstamp           int(11)     DEFAULT '0' NOT NULL,
      crdate           int(11)     DEFAULT '0' NOT NULL,
      cruser_id        int(11)     DEFAULT '0' NOT NULL,
      deleted          tinyint(4)  DEFAULT '0' NOT NULL,
      hidden           tinyint(4)  DEFAULT '0' NOT NULL,
      starttime        int(11)     DEFAULT '0' NOT NULL,
      endtime          int(11)     DEFAULT '0' NOT NULL,

      t3ver_oid        int(11)     DEFAULT '0' NOT NULL,
      t3ver_id         int(11)     DEFAULT '0' NOT NULL,
      t3ver_wsid       int(11)     DEFAULT '0' NOT NULL,
      t3ver_label      varchar(30) DEFAULT ''  NOT NULL,
      t3ver_state      tinyint(4)  DEFAULT '0' NOT NULL,
      t3ver_stage      int(11)     DEFAULT '0' NOT NULL,
      t3ver_count      int(11)     DEFAULT '0' NOT NULL,
      t3ver_tstamp     int(11)     DEFAULT '0' NOT NULL,
      t3ver_move_id    int(11)     DEFAULT '0' NOT NULL,
      t3_origuid       int(11)     DEFAULT '0' NOT NULL,

      sys_language_uid int(11)     DEFAULT '0' NOT NULL,
      l10n_parent      int(11)     DEFAULT '0' NOT NULL,
      l10n_diffsource  mediumtext,

      # Actual fields
      title            tinytext,
      description      text,
      type             varchar(30) DEFAULT 'static' NOT NULL,

      # for type=static
      files            int(11)     DEFAULT '0'      NOT NULL,

      # for type=folder:
      storage          int(11)     DEFAULT '0'      NOT NULL,
      folder           text                         NOT NULL,

      # for type=category:
      category         int(11)     DEFAULT '0'      NOT NULL,

      PRIMARY KEY (uid),
      KEY parent (pid,deleted),
      KEY t3ver_oid (t3ver_oid,t3ver_wsid)
   );


.. _DB-table-sys_metadata:

sys\_file\_metadata
===================

Table structure for table 'sys\_file\_metadata'::

   CREATE TABLE sys_file_metadata (
      uid               int(11)     NOT NULL auto_increment,
      pid               int(11)     DEFAULT '0' NOT NULL,
      tstamp            int(11)     DEFAULT '0' NOT NULL,
      crdate            int(11)     DEFAULT '0' NOT NULL,
      cruser_id         int(11)     DEFAULT '0' NOT NULL,

      # Language fields
      sys_language_uid  int(11)     DEFAULT '0' NOT NULL,
      l10n_parent       int(11)     DEFAULT '0' NOT NULL,
      l10n_diffsource   mediumblob              NOT NULL,

      # Versioning fields
      t3ver_oid         int(11)     DEFAULT '0' NOT NULL,
      t3ver_id          int(11)     DEFAULT '0' NOT NULL,
      t3ver_wsid        int(11)     DEFAULT '0' NOT NULL,
      t3ver_label       varchar(30) DEFAULT ''  NOT NULL,
      t3ver_state       tinyint(4)  DEFAULT '0' NOT NULL,
      t3ver_stage       int(11)     DEFAULT '0' NOT NULL,
      t3ver_count       int(11)     DEFAULT '0' NOT NULL,
      t3ver_tstamp      int(11)     DEFAULT '0' NOT NULL,
      t3ver_move_id     int(11)     DEFAULT '0' NOT NULL,
      t3_origuid        int(11)     DEFAULT '0' NOT NULL,

      # The metadata
      file          int(11)         DEFAULT '0' NOT NULL,
      title         tinytext,
      width         int(11)         DEFAULT '0' NOT NULL,
      height        int(11)         DEFAULT '0' NOT NULL,
      description   text,
      alternative   text,

      PRIMARY KEY (uid),
      KEY file (file),
      KEY t3ver_oid (t3ver_oid,t3ver_wsid),
      KEY fal_filelist (l10n_parent,sys_language_uid)
   );


.. _DB-table-sys_file_processedfile:

sys\_file\_processedfile
========================

Table structure for table 'sys\_file\_processedfile'.
It is a "temporary" file, like an image preview.
This table does not have a TCA representation, as it is only written
to using direct SQL queries in the code::

   CREATE TABLE sys_file_processedfile (
      uid               int(11)       NOT NULL auto_increment,
      tstamp            int(11)       DEFAULT '0' NOT NULL,
      crdate            int(11)       DEFAULT '0' NOT NULL,

      storage           int(11)       DEFAULT '0' NOT NULL,
      original          int(11)       DEFAULT '0' NOT NULL,
      identifier        varchar(512)  DEFAULT ''  NOT NULL,
      name              tinytext,
      configuration     text,
      configurationsha1 varchar(40)   DEFAULT ''  NOT NULL,
      originalfilesha1  varchar(40)   DEFAULT ''  NOT NULL,
      task_type         varchar(200)  DEFAULT ''  NOT NULL,
      checksum          varchar(255)  DEFAULT ''  NOT NULL,
      width             int(11)       DEFAULT '0',
      height            int(11)       DEFAULT '0',

      PRIMARY KEY (uid),
      KEY combined_1 (original,task_type,configurationsha1),
      KEY identifier (storage,identifier(199))
   );


.. _DB-table-sys_file_reference:

sys\_file\_reference
====================

Table structure for table 'sys\_file\_reference'.
It is one usage of a file with overloaded metadata::

   CREATE TABLE sys_file_reference (
      uid              int(11)       NOT NULL auto_increment,
      pid              int(11)       DEFAULT '0' NOT NULL,
      tstamp           int(11)       DEFAULT '0' NOT NULL,
      crdate           int(11)       DEFAULT '0' NOT NULL,
      cruser_id        int(11)       DEFAULT '0' NOT NULL,
      sorting          int(10)       DEFAULT '0' NOT NULL,
      deleted          tinyint(4)    DEFAULT '0' NOT NULL,
      hidden           tinyint(4)    DEFAULT '0' NOT NULL,

      # Versioning fields
      t3ver_oid        int(11)       DEFAULT '0' NOT NULL,
      t3ver_id         int(11)       DEFAULT '0' NOT NULL,
      t3ver_wsid       int(11)       DEFAULT '0' NOT NULL,
      t3ver_label      varchar(30)   DEFAULT ''  NOT NULL,
      t3ver_state      tinyint(4)    DEFAULT '0' NOT NULL,
      t3ver_stage      int(11)       DEFAULT '0' NOT NULL,
      t3ver_count      int(11)       DEFAULT '0' NOT NULL,
      t3ver_tstamp     int(11)       DEFAULT '0' NOT NULL,
      t3ver_move_id    int(11)       DEFAULT '0' NOT NULL,
      t3_origuid       int(11)       DEFAULT '0' NOT NULL,

      # Language fields
      sys_language_uid int(11)       DEFAULT '0' NOT NULL,
      l10n_parent      int(11)       DEFAULT '0' NOT NULL,
      l10n_diffsource  mediumblob                NOT NULL,

      # Reference fields (basically same as MM table)
      uid_local        int(11)       DEFAULT '0' NOT NULL,
      uid_foreign      int(11)       DEFAULT '0' NOT NULL,
      tablenames       varchar(64)   DEFAULT ''  NOT NULL,
      fieldname        varchar(64)   DEFAULT ''  NOT NULL,
      sorting_foreign  int(11)       DEFAULT '0' NOT NULL,
      table_local      varchar(64)   DEFAULT ''  NOT NULL,

      # Local usage overlay fields
      title            tinytext,
      description      text,
      alternative      tinytext,
      link             varchar(1024) DEFAULT ''  NOT NULL,
      downloadname     tinytext,

      PRIMARY KEY (uid),
      KEY parent (pid,deleted),
      KEY tablenames_fieldname (tablenames(32),fieldname(12)),
      KEY deleted (deleted),
      KEY uid_foreign (uid_foreign)
   );


      deleted          tinyint(4) DEFAULT '0' NOT NULL,
      hidden           tinyint(4) DEFAULT '0' NOT NULL,
      starttime        int(11) DEFAULT '0' NOT NULL,
      endtime          int(11) DEFAULT '0' NOT NULL,



.. _DB-table-sys_file_storage:

sys\_file\_storage
==================

Table structure for table 'sys\_file\_storage'::

   CREATE TABLE sys_file_storage (
      uid              int(11)     NOT NULL auto_increment,
      pid              int(11)     DEFAULT '0' NOT NULL,
      tstamp           int(11)     DEFAULT '0' NOT NULL,
      crdate           int(11)     DEFAULT '0' NOT NULL,
      cruser_id        int(11)     DEFAULT '0' NOT NULL,
      deleted          tinyint(4)  DEFAULT '0' NOT NULL,
      hidden           tinyint(4)  DEFAULT '0' NOT NULL,

      name             varchar(30) DEFAULT ''  NOT NULL,
      description      text,
      driver           tinytext,
      configuration    text,
      is_default       tinyint(4)  DEFAULT '0' NOT NULL,
      is_browsable     tinyint(4)  DEFAULT '0' NOT NULL,
      is_public        tinyint(4)  DEFAULT '0' NOT NULL,
      is_writable      tinyint(4)  DEFAULT '0' NOT NULL,
      is_online        tinyint(4)  DEFAULT '1' NOT NULL,
      processingfolder tinytext,

      PRIMARY KEY (uid),
      KEY parent (pid,deleted),
      KEY deleted_hidden (deleted,hidden)
   );


.. _DB-table-sys_filemounts:

sys\_filemounts
===============

Table structure for table 'sys\_filemounts'::

   CREATE TABLE sys_filemounts (
      uid      int(11)      unsigned NOT NULL auto_increment,
      pid      int(11)      unsigned DEFAULT '0' NOT NULL,
      tstamp   int(11)      unsigned DEFAULT '0' NOT NULL,
      hidden   tinyint(3)   unsigned DEFAULT '0' NOT NULL,
      deleted  tinyint(1)   unsigned DEFAULT '0' NOT NULL,
      sorting  int(11)      unsigned DEFAULT '0' NOT NULL,

      title    varchar(30)           DEFAULT ''  NOT NULL,
      path     varchar(120)          DEFAULT ''  NOT NULL,
      base     int(11)      unsigned DEFAULT '0' NOT NULL,

      PRIMARY KEY (uid),
      KEY parent (pid)
   );



