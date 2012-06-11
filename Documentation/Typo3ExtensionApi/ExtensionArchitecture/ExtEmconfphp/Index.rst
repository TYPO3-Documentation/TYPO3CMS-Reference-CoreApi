

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


ext\_emconf.php
^^^^^^^^^^^^^^^

This script configures the extension manager. The only thing included
is an array, :code:`$EM\_CONF[` :code:`*extension\_key*` :code:`]`
with these associative keys (below in table).

When extensions are imported from the online repository this file is
auto-written! So don't put any custom stuff in there - only change
values in the :code:`$EM\_CONF` array if needed.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key
   
   Data type
         Data type
   
   Description
         Description


.. container:: table-row

   Key
         title
   
   Data type
         string, required
   
   Description
         The name of the extension in English.


.. container:: table-row

   Key
         description
   
   Data type
         string, required
   
   Description
         Short and precise description in English of what the extension does
         and for whom it might be useful.


.. container:: table-row

   Key
         category
   
   Data type
         string
   
   Description
         Which category the extension belongs to:
         
         - **be**
           
           Backend (Generally backend oriented, but not a module)
         
         - **module**
           
           Backend modules (When something is a module or connects with one)
         
         - **fe**
           
           Frontend (Generally frontend oriented, but not a “true” plugin)
         
         - **plugin**
           
           Frontend plugins (Plugins inserted as a “Insert Plugin” content
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


.. container:: table-row

   Key
         shy
   
   Data type
         boolean
   
   Description
         If set, the extension will normally be hidden in the EM because it
         might be a default extension or otherwise something which is not so
         important. Use this flag if an extension is of “rare interest” (which
         is not the same as unimportant - just an extension not sought for very
         often...)
         
         It does not affect whether or not it's enabled. Only display in EM.
         
         Normally “shy” is set for all extensions loaded by default according
         to TYPO3\_CONF\_VARS.


.. container:: table-row

   Key
         dependencies
   
   Data type
         list of extension-keys
   
   Description
         This is a list of other extension keys which this extension depends on
         being loaded  *before* itself. The EM will manage that dependency
         while writing the extension list to localconf.php.
         
         **Deprecated** , use “constraints” instead.


.. container:: table-row

   Key
         conflicts
   
   Data type
         list of extension-keys
   
   Description
         List of extension keys of extensions with which this extension does
         *not* work (and so cannot be enabled before those other extensions are
         un-installed)
         
         **Deprecated** , use “constraints” instead.


.. container:: table-row

   Key
         constraints
   
   Data type
         array
   
   Description
         List of requirements, suggestions or conflicts with other extensions
         or TYPO3 or PHP version. Here's how a typical setup might look:
         
         ::
         
            'constraints' => array(
              'dependencies' => array(
                     'typo3' => '0.0.0-4.2.0',
                            'php' => '5.0.0-0.0.0' 
              ),
              'conflicts' => array(
                        'dam' => ''
                  ),
              'suggests' => array(
                         'tt_news' => '2.5.0-0.0.0'
                   )
            )
         
         “dependencies” lists extensions that this extension depends on.
         “conflicts” lists extensions which will not work with this extension.
         “suggests” is just suggestions of extensions that work together or
         enhance this extension.
         
         In the example above, it is indicated that the extension depends on a
         version of TYPO3 lower than 4.2 and a PHP version of at least 5.0. It
         will conflict with the DAM (any version) and it is suggested that it
         might be worth installing “tt\_news” (version at least 2.5.0).


.. container:: table-row

   Key
         priority
   
   Data type
         “top”, “bottom”
   
   Description
         This tells the EM to try to put the extensions as the very first in
         the list.


.. container:: table-row

   Key
         doNotLoadInFE
   
   Data type
         boolean
   
   Description
         If set, the extension will not be included in the list of extensions
         to be loaded in the frontend ( :code:`$TYPO3\_CONF\_VARS['extListFE']`
         ).
         
         New in TYPO3 4.3.
         
         **Background:** In TYPO3 versions  **before 4.3** the
         :code:`temp\_CACHED\*` files in folder :code:`typo3conf/` did always
         contain the content of the :code:`ext\_tables.php` and
         :code:`ext\_localconf.php` files of all installed extensions. However
         not all installed extensions are needed to render frontend output
         (e.g. wizard\_sortpages, tstemplate\_analyzer and others) and so their
         :code:`$EM\_CONF` array has the flag :code:`doNotLoadInFE` set. This
         will prevent TYPO3 from adding the extension's
         :code:`ext\_localconf.php` and :code:`ext\_tables.php` to the
         :code:`temp\_CACHED` files when rendering frontend content.
         
         Since 'extListFE' is shorter than the list of all extensions this will
         result in 2 new :code:`temp\_CACHED\_FE\*` files which are smaller
         than the files containing all extensions settings. This can save some
         precious milliseconds when delivering content.


.. container:: table-row

   Key
         loadOrder
   
   Data type
   
   
   Description
         (Not used)


.. container:: table-row

   Key
         module
   
   Data type
         list of strings
   
   Description
         If any subfolders to an extension contains backend modules, those
         folder names should be listed here. It allows the EM to know about the
         existence of the module, which is important because the EM has to
         update the conf.php file of the module in order to set the correct
         TYPO3\_MOD\_PATH constant.
         
         **Note:** this is not needed anymore if you use the dispatch mechanism
         for BE modules (see “Inside TYPO3”, chapter “Backend modules using
         typo3/mod.php”).


.. container:: table-row

   Key
         state
   
   Data type
         string
   
   Description
         Which state is the extension in?
         
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
         
         - **excludeFromUpdates** This state makes it impossible to update the
           extension through the extension manager (neither by the Update
           mechanism, nor by uploading a newer version to the installation). This
           is very useful if you made local changes to an extension for a
           specific installation and don't want any admin to overwrite them.
           *New in TYPO3 4.3.*


.. container:: table-row

   Key
         internal
   
   Data type
         boolean
   
   Description
         This flag indicates that the core source code is specifically aware of
         the extension. In other words this flag should convey the message that
         “this extension could not be written independently of core source code
         modifications”.
         
         An extension is not internal just because it uses TYPO3 general
         classes e.g. those from t3lib/.
         
         True non-internal extensions are characterized by the fact that they
         could be written without making core source code changes, but rely
         only on existing classes in TYPO3 and/or other extensions, plus its
         own scripts in the extension folder.


.. container:: table-row

   Key
         uploadfolder
   
   Data type
         boolean
   
   Description
         If set, then the folder named “uploads/tx\_[extKey-with-no-
         underscore]” should be present!


.. container:: table-row

   Key
         createDirs
   
   Data type
         list of strings
   
   Description
         Comma list of directories to create upon extension installation.


.. container:: table-row

   Key
         modify\_tables
   
   Data type
         list of tables
   
   Description
         List of table names which are only modified - not fully created - by
         this extension. Tables from this list found in the ext\_tables.sql
         file of the extension.


.. container:: table-row

   Key
         lockType
   
   Data type
         char; L, G or S
   
   Description
         Locks the extension to be installed in a specific position of the
         three posible:
         
         - **L** = local (typo3conf/ext/)
         
         - **G** = global (typo3/ext/)
         
         - **S** = system (typo3/sysext/)


.. container:: table-row

   Key
         clearCacheOnLoad
   
   Data type
         boolean
   
   Description
         If set, the EM will request the cache to be cleared when this
         extension is loaded.


.. container:: table-row

   Key
         author
   
   Data type
         string
   
   Description
         Author name (Use a-z)


.. container:: table-row

   Key
         author\_email
   
   Data type
         email address
   
   Description
         Author email address


.. container:: table-row

   Key
         author\_company
   
   Data type
         string
   
   Description
         Author company (if any company sponsors the extension).


.. container:: table-row

   Key
         CGLcompliance
   
   Data type
         keyword
   
   Description
         Compliance level that the extension claims to adhere to. A compliance
         defines certain coding guidelines, level of documentation, technical
         requirements (like XHTML, DBAL usage etc).
         
         Possible values are:
         
         - CGL360
         
         Please see the Project Coding Guidelines for a description of each
         compliance keyword (and the full allowed list).
         
         **Deprecated**


.. container:: table-row

   Key
         CGLcompliance\_note
   
   Data type
         string
   
   Description
         Any remarks to the compliance status. Might describe some minor
         incompatibilities or other reservations.
         
         **Deprecated**


.. container:: table-row

   Key
         private
   
   Data type
         boolean
   
   Description
         If set,  *this version* of the extension is not included in the public
         list!
         
         (Not supported anymore)


.. container:: table-row

   Key
         download\_password
   
   Data type
         string
   
   Description
         If set, this password must additionally be specified if people want to
         access (import or see details for) this the extension.
         
         (Not supported anymore)


.. container:: table-row

   Key
         version
   
   Data type
         main.sub.dev
   
   Description
         Version of the extension. Automatically managed by EM / TER. Format is
         [int].[int].[int]


.. ###### END~OF~TABLE ######

