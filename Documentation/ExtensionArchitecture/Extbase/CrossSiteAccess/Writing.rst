:navigation-title: Writing

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Cross-site access
..  _extbase-cross-site-writing:

=====================================
Writing records into a shared storage
=====================================

Writing across site boundaries is rare. A shared storage folder is usually
maintained in the backend by the editors of the site that owns it, and read
everywhere else. Where an extension does write — a registration form, a
submitted proposal — the question is a narrow one: **which page does the new
record land on?**

..  _extbase-cross-site-writing-resolution:

Where a new record is stored
============================

Extbase resolves the page for a new record in three steps, and stops at the
first that supplies a value:

#.  **The `pid` property of the object.** If the domain object exposes a
    readable `pid` and it is set, that page is used. This overrides everything
    else, so an object that carries a `pid` decides its own storage page.
#.  **`newRecordStoragePid` for the object's class.** The TypoScript setting
    :ref:`persistence.classes.<FQCN>.newRecordStoragePid
    <t3tsref:confval-plugin-persistence-classes-classname-newrecordstoragepid>`
    names a fixed page for every new record of one domain class. Note that it
    is keyed by the fully qualified class name of the model, not by the table.
#.  **The first entry of the read `storagePid`.** With nothing above set,
    Extbase takes the :ref:`storagePid
    <t3tsref:confval-plugin-persistence-storagepid>` it reads from and uses its
    **first** page.

..  warning::

    A repository configured to read from several pages writes to whichever page
    happens to be listed first. In a cross-site setup this might be the shared
    folder belonging to another site. If then even the default language does
    not match, you might end up with a record written to shared storage in the
    wrong language playing at default language.

..  _extbase-cross-site-writing-pinning:

Pinning the write target
========================

Wherever a repository reads from more than one page, set the write target
explicitly rather than relying on list order:

..  literalinclude:: _snippets/_newRecordStoragePid.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

This keeps reading and writing independent: the plugin lists conferences from
the shared folder and the local one, while new conferences are always created
locally.

Deciding the page in PHP instead means giving the model a `pid` property and
setting it before persisting. That suits a target which varies per record —
different for each site, or chosen by the visitor — where a single TypoScript
value cannot express it.

..  hint::

    The configuration shown above will not concern itself with the different
    language configuration the previous page :ref:`Matching languages between
    sites with locales <extbase-cross-site-locales>` covers. If reading in
    different languages is required out of such a setup, make sure in your
    record resolving to match the storage pids accordingly.

..  _extbase-cross-site-writing-language:

The language of a record written elsewhere
==========================================

Resolving a language for *reading* does not carry over to writing. Extbase
creates new records as default language records and cannot create translations.
That is true whatever page the record lands on. A record written into another
site's folder is a default-language record there.

..  seealso::

    `Writing records from the frontend
    <https://docs.typo3.org/permalink/t3coreapi:extbase-localisation-writing>`_
    — what language a new record gets, why Extbase cannot create translations,
    and when the DataHandler is the better tool.

..  _extbase-cross-site-writing-permissions:

Writing into a folder you do not own
====================================

Extbase persistence writes to the database directly rather than through the
:ref:`DataHandler <tce-database-basics>`, so no page permission check takes
place at all. The storage page is used as given, and the site boundary does not
constrain it.

That makes it worth being deliberate about the target. Where records genuinely
belong to another site and have to pass through its editorial process, use the
DataHandler instead: it enforces permissions, writes a history entry and
respects workspaces.
