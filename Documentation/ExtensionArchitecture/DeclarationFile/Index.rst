.. include:: /Includes.rst.txt

.. index::
   ! File; EXT:{extkey}/ext_emconf.php
   File; Declaration File
.. _extension-declaration:


=========================================
Declaration file (:file:`ext_emconf.php`)
=========================================

*-- required*  in legacy installations

The :file:`ext_emconf.php` is used in
:ref:`legacy installations not based on Composer <t3start:legacyinstallation>` to
supply information about the extension to the :guilabel:`Extensions` module. In
these installations the ordering of installed extensions and their dependencies
are loaded from this file as well.

.. versionchanged:: 11.4
   The ordering of installed extensions and their dependencies are loaded from
   the :file:`composer.json` file, instead of :file:`ext_emconf.php` in
   Composer installations.

The only thing included
is an associative array, :php:`$EM_CONF[extension key]`.
The keys are described in the table below.

This file is overwritten, when extensions are imported from the online
repository. So don't write your custom code in this file - only change
values in the :php:`$EM_CONF` array if needed.


.. code-block:: php

   <?php
   $EM_CONF[$_EXTKEY] = [
       'title' => 'Extension title',
       'description' => 'Extension description',
       'category' => 'plugin',
       'author' => 'John Doe',
       'author_email' => 'john.doe@example.org',
       'author_company' => 'some company',
       'state' => 'stable',
       'clearCacheOnLoad' => 0,
       'version' => '1.0.0',
       'constraints' => [
           'depends' => [
               'typo3' => '11.5.0-11.99.99',
           ],
           'conflicts' => [
           ],
           'suggests' => [
           ],
       ],
   ];

.. index:: $_EXTKEY

$_EXTKEY is set globally and contains the extension key.

.. important::
   Due to limitations to the TER (`TYPO3 Extension Repository <https://extensions.typo3.org>`__),
   `$_EXTKEY` should be used here and **not** a constant or a string.


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
         version
   :Data type:
         string
   :Description:
         Version of the extension. Automatically managed by EM / TER. Format is
         [int].[int].[int]
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

         - **distribution**

           Distribution, an extension kickstarting a full site

 - :Key:
         constraints
   :Data type:
         array
   :Description:
         List of requirements, suggestions or conflicts with other extensions
         or TYPO3 or PHP version. Here's how a typical setup might look:

         .. code-block:: php
            :caption: EXT:some_extension/ext_emconf.php

            'constraints' => [
                'depends' => [
                    'typo3' => '10.4.0-11.5.99',
                    'php' => '7.4.0-8.0.99'
                ],
                'conflicts' => [
                    'templavoilaplus' => ''
                ],
                'suggests' => [
                    'news' => '9.0.0-0.0.0'
                ],
            ]

         depends
           List of extensions that this extension depends on.
           Extensions defined here will be loaded *before* the current extension.

         conflicts
            List of extensions which will not work with this extension.

         suggests
           List of suggestions of extensions that work together or
           enhance this extension.
           Extensions defined here will be loaded *before* the current extension.
           Dependencies take precedence over suggestions.
           Loading order especially matters when overriding TCA or SQL of another extension.

         The above example indicates that the extension depends on a
         version of TYPO3 between 10.4 and 11.5 (as only bug and security fixes are
         integrated into TYPO3 when the last digit of the version changes, it is
         safe to assume it will be compatible with any upcoming version of the
         corresponding branch, thus ``.99``). Also the extension has been
         tested and is known to work properly with PHP 7.4. and 8.0 It
         will conflict with "templavoilaplus" (any version) and it is suggested
         that it might be worth installing "news" (version at least 9.0.0).
         Be aware that you should add *at least* the TYPO3 and PHP version constraints
         to this file to make sure everything is working properly.

         For legacy installations the :file:`ext_emconf.php` file
         is the source of truth for required dependencies and the loading order
         of active extensions.

         .. note::
            Extension authors should ensure that the information here is in sync
            with the :file:`composer.json` file.
            This is especially important regarding constraints like `depends`,
            `conflicts` and `suggests`. Use the equivalent settings as in
            :file:`composer.json` `require`, `conflict` and `suggest` to set
            dependencies and ensure a specific loading order.

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
           extensions carry a responsibility to maintain and improve them.

         - **experimental**

           Experimental state is useful for anything experimental - of course.
           Nobody knows if this is going anywhere yet... Maybe still just an
           idea.

         - **test**

           Test extension, demonstrates concepts, etc.

         - **obsolete**

           The extension is obsolete or deprecated. This can be due to other
           extensions solving the same problem but in a better way or if the
           extension is not being maintained anymore.

         - **excludeFromUpdates**

           This state makes it impossible to update the
           extension through the Extension Manager (neither by the Update
           mechanism, nor by uploading a newer version to the installation). This
           is very useful if you made local changes to an extension for a
           specific installation and don't want any admin to overwrite them.

 - :Key:
         clearCacheOnLoad
   :Data type:
         boolean
   :Description:
         If set, the EM will request all caches (incl. FE cache) to be cleared when this
         extension is loaded. If false (default), only system cache will be cleared.

 - :Key:
         author
   :Data type:
         string
   :Description:
         Author name

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
         Author company


 - :Key:
         autoload
   :Data type:
         array
   :Description:
         To get better class loading support for websites in legacy mode
         the following information can be provided.

         **Extensions having one folder with classes or single files**

         Considering you have an Extbase extension (or an extension where all classes
         and interfaces reside in a :file:`Classes` folder) or single classes you can simply
         add the following to your :file:`ext_emconf.php` file:

         .. code-block:: php
            :caption: EXT:some_extension/ext_emconf.php

            'autoload' => [
               'classmap' => [
                  'Classes',
                  'a-class.php',
               ]
            ],

         **Extensions using namespaces**

         If the extension has namespaced classes following the PSR-4 standard, then you
         can add the following to your :file:`ext_emconf.php` file:

         .. code-block:: php
            :caption: EXT:some_extension/ext_emconf.php

            'autoload' => [
               'psr-4' => [
                  'Vendor\\ExtName\\' => 'Classes'
               ]
            ],

         .. important::
            The prefix must end with a backslash.

 - :Key:
         autoload-dev
   :Data type:
         array
   :Description:
         Same as the configuration "autoload" but it is only used if the
         *ApplicationContext* is set to *Testing*.


Deprecated configuration
========================

See older versions of this page.
