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
   
   Another convenient way to install extensions is offered by using composer (https://getcomposer.org/).
   Besides TYPO3 CMS itself the TYPO3 composer repository includes all TYPO3 Extensions that are uploaded to TER.
   Read more on https://composer.typo3.org/ .

#. You must *install* it.

   An extension is loaded only if its `state` is set to `active`
   in the PackageStates.php file.
   Extensions are loaded in the order they appear in this list.

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
   an array in the variable `$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][extensionKey]`.

Loaded extensions are registered in a global variable,
`$TYPO3_LOADED_EXT`, available in both frontend and backend of TYPO3.

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
the order they were listed in PackageStates.php.

The inclusion of `ext_tables.php` or `ext_localconf.php` files (see next chapter) is done
by traversing (a copy of) the `$TYPO3_LOADED_EXT` array.

