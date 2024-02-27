.. include:: /Includes.rst.txt
.. index:: Plugin; Create
.. _Create-plugins:

==============
Create plugins
==============

How to create plugins with the Extbase framework and Fluid templating engine
is handled in depth in the chapter
:ref:`extbase_registration_of_frontend_plugins`.

There are basically three ways to create plugins in TYPO3:

#.  With the Extbase framework using :php:`configurePlugin()` in the file
    :file:`ext_localconf.php` and :php:`registerPlugin()` in the file
    :file:`Configuration/TCA/Overrides/tt_content.php`
#.  Create a frontend plugin using Core functionality and a custom controller

Generally speaking, if you already use Extbase, it is good practice to
create your plugins using the Extbase framework. This also involves:

*   creating controller actions
*   create a domain model and repository (if your plugin requires records
    that are persisted in the database)
*   create a view using Fluid templates
