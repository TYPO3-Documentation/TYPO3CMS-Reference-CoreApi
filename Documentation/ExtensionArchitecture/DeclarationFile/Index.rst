.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _extension-declaration:

Declaration file
^^^^^^^^^^^^^^^^

The `ext_emconf.php` is the single most important file in an extension.
Without it, the Extension Manager (EM) will not detect the extension, much less
be able to install it. This file contains a declaration of what the extension
is or does for the EM. The only thing included
is an associative array, :code:`$EM_CONF[extension key]`.
The keys are described in the table below.

When extensions are imported from the online repository this file is
written anew! So don't put any custom stuff in there - only change
values in the :code:`$EM_CONF` array if needed.

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Data type,20: Data type
   :Description,60: Description

 - :Key:
         title
   :Data type:
         string, required
   :Description:
         The name of the extension in English.

 - :Key:
         description
   :Data type:
         string, required
   :Description:
         Short and precise description in English of what the extension does
         and for whom it might be useful.

 - :Key:
         category
   :Data type:
         string
   :Description:
         Which category the extension belongs to:

         - **be**

           Backend (Generally backend-oriented, but not a module)

         - **module**

           Backend modules (When something is a module or connects with one)

         - **fe**

           Frontend (Generally frontend oriented, but not a "true" plugin)

         - **plugin**

           Frontend plugins (Plugins inserted as a "Insert Plugin" content
           element)

         - **misc**

           Miscellaneous stuff (Where not easily placed elsewhere)

         - **services**

           Contains TYPO3 services

         - **templates**

           Contains website templates

         - **example**

           Example extension (Which serves as examples etc.)

         - **doc**

           Documentation (e.g. tutorials, FAQ's etc.)

 - :Key:
         shy
   :Data type:
         boolean
   :Description:
         If set, the extension will normally be hidden in the EM because it
         might be a default extension or otherwise something which is not so
         important. Use this flag if an extension is of "rare interest" (which
         is not the same as unimportant - just an extension not sought for very
         often...)

         It does not affect whether or not it's enabled. Only display in EM.

         Normally "shy" is set for all extensions loaded by default according
         to :code:`$TYPO3_CONF_VARS`.

 - :Key:
         dependencies
   :Data type:
         list of extension-keys
   :Description:
         This is a list of other extension keys which this extension depends on
         being loaded  *before* itself. The EM will manage that dependency
         while writing the extension list to localconf.php.

         **Deprecated** , use "constraints" instead.

 - :Key:
         conflicts
   :Data type:
         list of extension-keys
   :Description:
         List of extension keys of extensions with which this extension does
         *not* work (and so cannot be enabled before those other extensions are
         un-installed)

         **Deprecated** , use "constraints" instead.

 - :Key:
         constraints
   :Data type:
         array
   :Description:
         List of requirements, suggestions or conflicts with other extensions
         or TYPO3 or PHP version. Here's how a typical setup might look::

            'constraints' => array(
                'depends' => array(
                    'typo3' => '4.5.0-6.1.99',
                    'php' => '5.3.0-5.5.99'
                ),
                'conflicts' => array(
                    'dam' => ''
                ),
                'suggests' => array(
                    'tt_news' => '2.5.0-0.0.0'
                )
            )

         depends
           List of extensions that this extension depends on.

         conflicts
         	List of extensions which will not work with this extension.

         suggests
           List of suggestions of extensions that work together or
           enhance this extension.

         The above example indicated that the extension depends on a
         version of TYPO3 between 4.5 and 6.1 (as only bug and security fixes are
         integrated into TYPO3 when the last digit of the version changes, it is
         safe to assume it will be compatible with any upcoming version of the
         corresponding branch, thus ``.99``). Also the extension has been
         tested and is known to work properly with PHP 5.3, 5.4 and 5.5. It
         will conflict with the DAM (any version) and it is suggested that it
         might be worth installing "tt\_news" (version at least 2.5.0).

 - :Key:
         priority
   :Data type:
         "top", "bottom"
   :Description:
         This tells the EM to try to put the extension as the very first
         or the very last in the list.

 - :Key:
         doNotLoadInFE
   :Data type:
         boolean
   :Description:
         You may come across this flag in some custom extensions. However it
         was never supported by the TER and thus never widely used. It was
         introduced in TYPO3 4.3 and removed in TYPO3 6.0.

 - :Key:
         loadOrder
   :Data type:
   :Description:
         (Not used)

 - :Key:
         module
   :Data type:
         list of strings
   :Description:
         If any subfolders to an extension contains backend modules, those
         folder names should be listed here. It allows the EM to know about the
         existence of the module, which is important because the EM has to
         update the conf.php file of the module in order to set the correct
         :code:`TYPO3_MOD_PATH` constant.

         **Note:** this is not needed anymore if you use the dispatch mechanism
         for BE modules (see "Inside TYPO3", chapter "Backend modules using
         typo3/mod.php").

 - :Key:
         state
   :Data type:
         string
   :Description:
         Which state is the extension in

         - **alpha**

           Alpha state is used for very initial work, basically the state is has
           during the very process of creating its foundation.

         - **beta**

           Under current development. Beta extensions are functional but not
           complete in functionality. Most likely beta-extensions will not be
           reviewed.

         - **stable**

           Stable extensions are complete, mature and ready for production
           environment. You will be approached for a review. Authors of stable
           extensions carry a responsibility to be maintain and improve them.

         - **experimental**

           Experimental state is useful for anything experimental - of course.
           Nobody knows if this is going anywhere yet... Maybe still just an
           idea.

         - **test**

           Test extension, demonstrates concepts etc.

         - **obsolete**

           The extension is obsolete or deprecated. This can be due to other
           extensions solving the same problem but in a better way or if the
           extension is not being maintained anymore.

         - **excludeFromUpdates**

           This state makes it impossible to update the
           extension through the extension manager (neither by the Update
           mechanism, nor by uploading a newer version to the installation). This
           is very useful if you made local changes to an extension for a
           specific installation and don't want any admin to overwrite them.

           *New since TYPO3 4.3.*

 - :Key:
         internal
   :Data type:
         boolean
   :Description:
         This flag indicates that the core source code is specifically aware of
         the extension. In other words this flag should convey the message that
         "this extension could not be written independently of core source code
         modifications".

         An extension is not internal just because it uses TYPO3 general
         classes e.g. those from t3lib/.

         True non-internal extensions are characterized by the fact that they
         could be written without making core source code changes, but rely
         only on existing classes in TYPO3 and/or other extensions, plus its
         own scripts in the extension folder.

         **This is a prehistorical practice. If your extension requires some changes
         in the TYPO3 Core, you should make a hook request instead.**

 - :Key:
         uploadfolder
   :Data type:
         boolean
   :Description:
         If set, then the folder named "uploads/tx\_[extKey-with-no-
         underscore]" should be present!

 - :Key:
         createDirs
   :Data type:
         list of strings
   :Description:
         Comma list of directories to create upon extension installation.

 - :Key:
         modify\_tables
   :Data type:
         list of tables
   :Description:
         List of table names which are only modified - not fully created - by
         this extension. Tables from this list found in the ext\_tables.sql
         file of the extension.

 - :Key:
         lockType
   :Data type:
         char; L, G or S
   :Description:
         Locks the extension to be installed in a specific position of the
         three posible:

         - **L** = local (typo3conf/ext/)

         - **G** = global (typo3/ext/)

         - **S** = system (typo3/sysext/)

 - :Key:
         clearCacheOnLoad
   :Data type:
         boolean
   :Description:
         If set, the EM will request the cache to be cleared when this
         extension is loaded.

 - :Key:
         author
   :Data type:
         string
   :Description:
         Author name (Use a-z)

 - :Key:
         author\_email
   :Data type:
         email address
   :Description:
         Author email address

 - :Key:
         author\_company
   :Data type:
         string
   :Description:
         Author company (if any company sponsors the extension).

 - :Key:
         docPath
   :Data type:
         string
   :Description:
         Path to documentation. This has never been fully supported neither by the TER
         nor by the Extension Manager. The documentation is expected to be in folder :file:`doc`
         when using OpenOffice/LibreOffice format and in folder :file:`Documentation` when
         using reStructuredText (recommended). See :ref:`extension-documentation` for more information.

         **Deprecated**

 - :Key:
         CGLcompliance
   :Data type:
         keyword
   :Description:
         Compliance level that the extension claims to adhere to. A compliance
         defines certain coding guidelines, level of documentation, technical
         requirements (like XHTML, DBAL usage etc).

         **Deprecated**

 - :Key:
         CGLcompliance\_note
   :Data type:
         string
   :Description:
         Any remarks to the compliance status. Might describe some minor
         incompatibilities or other reservations.

         **Deprecated**

 - :Key:
         private
   :Data type:
         boolean
   :Description:
         If set,  *this version* of the extension is not included in the public
         list!

         **Not supported anymore**

 - :Key:
         download\_password
   :Data type:
         string
   :Description:
         If set, this password must additionally be specified if people want to
         access (import or see details for) this the extension.

         **Not supported anymore**

 - :Key:
         version
   :Data type:
         main.sub.dev
   :Description:
         Version of the extension. Automatically managed by EM / TER. Format is
         [int].[int].[int]

