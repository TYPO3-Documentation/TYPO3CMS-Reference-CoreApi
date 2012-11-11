.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _extension-install:

Installing extensions
^^^^^^^^^^^^^^^^^^^^^

There are only two (possibly three) steps involved in using
extensions with TYPO3:

#. You must *import* it.

   This simply means to copy the extensions files
   into the correct directory in either typo3/ext/ (global) or
   typo3conf/ext/ (local). More commonly you import an extension directly
   from the online TYPO3 Extension Repository (TER). When an extension is found
   located in one of the extension locations, it is  *available* to the
   system.

   The Extension Manager (EM) should take care of this process, including updates to
   newer versions if needed.Notice that backend modules will have their
   "conf.php" file modified in the install process depending on whether
   they are installed locally or globally!

#. You must *install* it.

   An extension is loaded only if its extension
   key is listed in the comma-delimited list in the variable
   `$TYPO3_CONF_VARS["EXT"]["extList"]`. The list of enabled extensions
   must be set and modified from inside typo3conf/localconf.php.
   Extensions are loaded in the order they appear in this list. Any
   extensions listed in `$TYPO3_CONF_VARS["EXT"]["requiredExt"]` will be
   forcibly loaded before any extensions in
   `$TYPO3_CONF_VARS["EXT"]["extList"]`.

   An enabled extension is always
   global to the TYPO3 Installation - you cannot disable an extension
   from being loaded in a particular branch of the page tree.The EM takes
   care enabling extensions. It's highly recommended that the EM is doing
   this, because the EM will make sure the priorities, dependencies and
   conflicts are managed according to the extension characteristics,
   including clearing of the cache-files if any.

#. You *might* need to configure it.

   Certain extensions may allow you to
   configure some settings. Again the EM is able to handle the
   configuration of the extensions based on a certain API for this. Any
   settings - if present - configured for an extension are available as
   an array in the variable `$TYPO3_CONF_VARS["EXT"]["extConf"][extension key]`.

Loaded extensions are registered in a global variable,
`$TYPO3_LOADED_EXT`, available in both frontend and backend of TYPO3.
The loading and registration process happens in
`t3lib/config_default.php`. Since TYPO3 4.3, when rendering FE content
(`TYPO3_MODE = FE`), `$TYPO3_LOADED_EXT` contains only extensions where
the `$EM_CONF` option (see later) "doNotLoadInFE" is not set.

This is how the data structure for an extension in this array looks::

   $TYPO3_LOADED_EXT[extension key] = array(
           "type" =>                S, G, L for system, global or local type of availability.
           "siteRelPath" => Path of extension dir relative to the PATH_site constant
                                   e.g. "typo3/ext/my_ext/" or "typo3conf/ext/my_ext/"
           "typo3RelPath" => Path of extension dir relative to the "typo3/" admin folder
                                   e.g. "ext/my_ext/" or "../typo3conf/ext/my_ext/"
           "ext_localconf" => Contains absolute path to 'ext_localconf.php' file if present
           "ext_tables" => [same]
           "ext_tables_sql" => [same]
           "ext_tables_static+adt.sql" => [same]
           "ext_typoscript_constants.txt" => [same]
           "ext_typoscript_setup.txt" => [same]
           "ext_typoscript_editorcfg.txt" => [same]
   )

The order of the registered extensions in this array corresponds to
the order they were listed in `$TYPO3_CONF_VARS["EXT"]["requiredExt"]`
and `$TYPO3_CONF_VARS["EXT"]["extList"]` with duplicates removed, of
course.

The inclusion of `ext_tables.php` or `ext_localconf.php` files (see next chapter) is done
by traversing (a copy of) the `$TYPO3_LOADED_EXT` array.

