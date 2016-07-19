.. include:: ../../Includes.txt


.. _extension-configuration-files:

Configuration files
^^^^^^^^^^^^^^^^^^^

Files :code:`ext_tables.php` and :code:`ext_localconf.php` are the two
most important files for the execution of extensions
within TYPO3. They contain configuration used by the system on almost
every request. They should therefore be optimized for speed.

- :code:`ext_localconf.php` is always included in global scope of the script,
  either frontend or backend.

  While you *can* put functions and classes into
  the script, it is a really bad practice because
  such classes and functions would *always* be loaded.
  It is better to have them included only as needed.

  So stick to changing values in :code:`TYPO3_CONF_VARS` only!

- :code:`ext_tables.php` is *not* always included in global scope (in the frontend)

  It should still not contain functions and classes as it still very often loaded.

- Use the API of class :code:`extMgm` for tasks such as
  adding tables, merging information into arrays, etc.

- Before the inclusion of any of the two files, the variables :code:`$_EXTKEY`
  is set to the extension key and :code:`$_EXTCONF` is set
  to the configuration from :code:`$TYPO3_CONF_VARS["EXT"]["extConf"][extension key]`

- :code:`$TYPO3_LOADED_EXT[extension key]` contains information about
  whether the module is loaded as *local, global* or *system* type,
  including the proper paths you might use, absolute and relative.

- The inclusion can happen in two ways:

  - Either the files are included individually on each request (many file
    includes) (:code:`$TYPO3_CONF_VARS["EXT"]["extCache"]=0;`)

  - or (better) the files are automatically imploded into one single
    temporary file (cached) in `typo3temp/Cache/Code/cache_core` directory (only one file
    include) (:code:`$TYPO3_CONF_VARS["EXT"]["extCache"]=1;`). This is
    default.

  In effect this means:

  - Your :code:`ext_tables.php` and :code:`ext_localconf.php` file must be designed so
    that they can safely be read and subsequently imploded into one single
    file with all the other configuration scripts!

  - You must **never** use a "return" statement in the files global scope -
    that would make the cached script concept break.

  - You should **not** rely on the PHP constant :code:`__FILE__` for detection of
    include path of the script - the configuration might be executed from
    a cached script and therefore such information should be derived from
    the :code:`$TYPO3_LOADED_EXT[extension key]` array, e.g.
    :code:`$TYPO3_LOADED_EXT[$_EXTKEY]["siteRelPath"]`.

