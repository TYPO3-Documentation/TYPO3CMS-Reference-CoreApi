.. include:: /Includes.rst.txt
.. index:: Localization; Domain objects

=============================
Multi-language domain objects
=============================

.. todo: Overhaul this chapter

.. attention::
   This section only applies to models based on Extbase.

With TYPO3, you can localize the data sets in the backend. This also
applies to domain data because they are treated as "normal" data sets
in TYPO3. To make your domain objects translatable, you have
to create additional fields in the database and tell TYPO3 about them. The
class definitions must not be changed. Let's look at the required
steps based on the :php:`Blog` model class of the blog example. TYPO3
needs three additional database fields which you should insert in the
:file:`ext_tables.sql` file:

.. code-block:: sql
   :caption: EXT:blog_example/ext_tables.sql

   CREATE TABLE tx_blogexample_domain_model_blog (
       --  ...
       sys_language_uid int(11) DEFAULT '0' NOT NULL,
       l10n_parent int(11) DEFAULT '0' NOT NULL,
       l10n_diffsource mediumblob NOT NULL,
       -- ...
   );

You are free to choose the names of the database fields, but the
names we use here are common in the world of TYPO3. In any case, you have
to tell TYPO3 which name you have chosen. This is done in the ``ctrl``
section of the TCA configuration file
:file:`Configuration/TCA/tx_blogexample_domain_model_blog.php`


.. code-block:: sql
   :caption: EXT:blog_example/Configuration/TCA/tx_blogexample_domain_model_blog.php

   <?php

   return [
       'ctrl' => [
           // ...
           'languageField' => 'sys_language_uid',
           'transOrigPointerField' => 'l10n_parent',
           'transOrigDiffSourceField' => 'l10n_diffsource',
           // ...
       ]
   ];

The field ``sys_language_uid`` is used for storing
the UID of the language in which the blog is written. Based on this UID
Extbase chooses the right translation depending on the current site. In the field
``l10n_parent`` the UID of the original blog record created in the
default language, which the current blog record is a translation of. The third
field, ``l10n_diffsource`` contains a snapshot of the source of
the translation. This snapshot is used in the backend for the creation of a
differential view and is not used by Extbase.

In the section ``columns`` of the ``TCA`` you have
to configure the fields accordingly. The following configuration adds two
fields to the backend form of the blog: one field for the editor to define
the language of a data record and one field to select the data record the
translation relates to.


.. code-block:: sql
   :caption: EXT:blog_example/Configuration/TCA/tx_blogexample_domain_model_blog.php

   <?php

   return [
       // ...
       'types' => [
           '1' => ['showitem' => 'l10n_parent , sys_language_uid, hidden, title,
                       description, logo, posts, administrator'],
       ],
       'columns' => [
           'sys_language_uid' => [
               'exclude' => 1,
               'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.php:LGL.language',
               'config' => [
                   'type' => 'select',
                   'foreign_table' => 'sys_language',
                   'foreign_table_where' => 'ORDER BY sys_language.title',
                   'items' => [
                       ['LLL:EXT:core/Resources/Private/Language/locallang_general.php:LGL.allLanguages',-1],
                       ['LLL:EXT:core/Resources/Private/Language/locallang_general.php:LGL.default_value',0]
                   ],
               ],
           ],
           'l10n_parent' => [
               'displayCond' => 'FIELD:sys_language_uid:>:0',
               'exclude' => 1,
               'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.php:LGL.l10n_parent',
               'config' => [
                 'type' => 'select',
                 'items' => [
                     ['', 0],
                 ],
                 'foreign_table' => 'tx_blogexample_domain_model_blog',
                 'foreign_table_where' => 'AND tx_blogexample_domain_model_blog.uid=###REC_FIELD_l10n_parent### AND tx_blogexample_domain_model_blog.sys_language_uid IN (-1,0)',
               ],
           ],
           'l10n_diffsource' => [
               'config' => [
                 'type' =>'passthrough'
               ],
           ],
           // ...
       ],
   ];

With it, the localization of the domain object is already
configured. By adding ``&amp;L=1`` to the URL, the language of
the frontend will be changed to german. If there is an existing
translation of a blog, it will be shown. Otherwise, the blog is displayed in
the default language.

.. tip::

    You can control this behavior. If you configure the site to strict
    language mode, then only those objects are shown, which really
    have content in the frontend language. More information for this you
    will find in the *Frontend Localization Guide* of the
    *Core Documentation*.

How TYPO3 handles the localization of content offers two
important specific features: The first is that all translations of a data
record respectively a data record that is valid for all languages (UID of
the language is 0 or -1) will be "added" to the data record in the default
language. The second special feature is that always the UID of the record
in the default language is bound for identification although the
translated data record in the database table has another UID. This
conception has a serious disadvantage: If you want to create a data record
for a language with no data record in the default language, you have
to create the latter before. But with what content?

Let's have an example for illustration: You create a blog in the
default language English (=default). It is stored in the database like
this:

.. code-block:: none
   :caption: Example database content

   uid:              7 (given by the database)
   title:            "My first Blog"
   sys_language_uid: 0 (selected in backend)
   l10n_parent:      0 (no translation original exists)

After a while, you create a German translation in the backend. In the
database the following record is stored:

.. code-block:: none
   :caption: Example database content

   uid:              42 (given by the database)
   title:            "Mein erster Blog"
   sys_language_uid: 1 (selected in backend)
   l10n_parent:      7 (selected in backend respectively given automatically)

A link that references the single view of a blog looks like
this:

:samp:`https://example.org/index.php?id=99&amp;tx_blogexample_pi1[controller]=Blog&amp;tx_blogexample_pi1[action]=show&amp;tx_blogexample_pi1[blog]=7`

By adding ``&amp;L=1`` we referencing now the German
version:

:samp:`https://example.org/index.php?id=99&amp;tx_blogexample_pi1[controller]=Blog&amp;tx_blogexample_pi1[action]=show&amp;tx_blogexample_pi1[blog]=7&amp;L=1`

Notice that the given UID in `tx_blogexample_pi1[blog]=7` is not
changed. There is not the UID of the data record of the german translation used
(42). This has the advantage that only the parameter for the language
selection is enough. Concurrently it has the disadvantage of a higher
administration effort during persistence. Extbase will do this for you by
carrying the UID of the language of the domain model and the UID of the
data record in which the domain data is effectively stored as "hidden"
properties of the :php:`AbstractDomainObject` internally.
In Table 9-2, you find for different actions in the frontend the behavior
of Extbase for localized domain objects.

*Table 9-2: Behavior of Extbase for localized domain
objects in the frontend.*

+-----------------+-----------------------------------+------------------------------------+
|                 |No parameter L given, or L=0       |L=x (x>0)                           |
+-----------------+-----------------------------------+------------------------------------+
|Display (index,  |Objects in the default language    |The objects are shown in the        |
|list, show)      |(``sys_language_uid=0``)           |selected language x. If an object   |
|                 |respectively object for all        |doesn't exist in the selected       |
|                 |languages (``sys_language_uid=-1``)|language the object of the default  |
|                 |are shown                          |language is shown (except by        |
|                 |                                   |``sys_language_mode=strict``)       |
+-----------------+-----------------------------------+------------------------------------+
|Editing (edit,   |Like displaying an object. The domain data is stored in the "translated"|
|update)          |data record, in the above example in the record with the UID 42.        |
+-----------------+------------------------------------------------------------------------+
|Creation (new,   |Independent of the selected frontend language the data is stored in a   |
|create)          |new record in whose field ``sys_language_uid`` the number 0 is inserted.|
+-----------------+-----------------------------------+------------------------------------+

Extbase also supports all default functions of the localization of
domain objects. It has its limits when a domain object should be created
exclusively in a target language. Especially when no data record exists in
the default language.
