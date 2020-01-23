.. include:: ../../Includes.txt

.. _create plugins:

==============
Create Plugins
==============

How to create plugins with the Extbase framework and Fluid templating engine is handled
in depth in the chapter :ref:`t3extbasebook:configuring-the-plugin` in the "Extbase / Fluid book".

There are basically two ways to create plugins in TYPO3:

#. With the Extbase framework using :php:`configurePlugin()` in the file :file:`ext_localconf.php`
   and :php:`registerPlugin()` in the file :file:`Configuration/TCA/Overrides/tt_content.php`
#. Create a plugin using :php:`AbstractPlugin` **without** Extbase.

Generally speaking, if you already use Extbase, it is good practice to create your plugins
using the Extbase framework. This also involves:

* creating controller actions
* create a domain model and repository (if your plugin requires records that are persisted in the database)
* create a view using Fluid templates
