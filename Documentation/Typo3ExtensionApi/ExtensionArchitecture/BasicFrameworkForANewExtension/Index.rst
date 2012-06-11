.. include:: Images.txt

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


Basic framework for a new extension
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This document will not describe in detail how to create extensions. It
only aims to be a reference for the facts regarding the rules of how
extensions register with the system.

To learn to create extensions you should read one of the extension
tutorials that are available. They will take you through the process
step by step and explain best-practices for you.

To start up a new extension the most popular tool is the Extension
Kickstarter. From a series of menus it allows you to configure a basic
set of features you want to get into your extension and a selection of
default files will be created. The idea is that you continue to
develop these files into your specific application.


Registering an extension key
""""""""""""""""""""""""""""

Before starting a new extension you should register an extension key
on typo3.org (unless you plan to make an implementation-specific
extension – of course – which it does not make sense to share).

Go to typo3.org, log in with your (pre-created) username / password
and go to Extensions > Extension Keys and click on the “Register keys”
tab. On that page you can enter the key name you want to register.


|img-5| Enabling the Extension Kickstarter
""""""""""""""""""""""""""""""""""""""""""

Before you can use the Extension Kickstarter you will have to enable
it. The "Kickstarter" is an extension like any other (key:
"kickstarter") so it must be installed first:

|img-6| After the installation of the extension you will find a new
menu item named "Create new extension" in the selector box menu of the
Extension Manager.


Using the Extension Kickstarter
"""""""""""""""""""""""""""""""

|img-7| In the Kickstarter you should always fill in the General
Information which includes the title, description, author name etc for
the extension. But the most important thing is to enter the extension
key as the very first thing!

After entering this information you can begin to create new tables and
fields in the database, you can configure backend modules and frontend
plugins etc. Basically this is what tutorials will cover in detail.

When you are through with the configuration you click the button to
the left called "View result". This will let you preview the content
of the files the Kickstarter will write to the server.

|img-8| It is important that you write the extension to the correct
location. Most likely that will be "Local" in your case.

Finally, if there already is an extension with the same extension key
*every file from that extension will be overwritten with the
Kickstarter's output!* Remember: This is *a kickstarter, not an
editor!* It is meant to kick you off with the development of your new
TYPO3 extension and nothing more! So of course it overwrites all
existing files!


Enabling your newly created extension
"""""""""""""""""""""""""""""""""""""

After the extension is written to the server's disk you should see a
message like this, which allows you to install your extension
immediately:


|img-9| Re-edit the extension
"""""""""""""""""""""""""""""

In the process of creating an extension it is rather typical to go
back to the Kickstarter a few times to fine tune the base code.
Experience suggests that this is especially useful to tuning the
configuration of database tables and fields.

The Kickstarter generates 2 files while it is working:
:code:`doc/wizard\_form.dat` and :code:`doc/wizard\_form.html` . As
long as these two files are present, the extension can be edited
again. Obviously you should remove those files once you are done with
the Kickstarter.

If you want to load the Kickstarter with the original configuration
used for your extension so you can add or edit features, just click
the extension title in the list of loaded/available extensions and
select "Edit in Kickstarter" from the menu:

|img-10| You should be back to the Kickstarter with all the original
configuration used (provided the files mentioned above still exist).


**Warning about re-editing**
""""""""""""""""""""""""""""

This feature is potentially dangerous as it may give the impression
that the Kickstarter is an editor. So once more:  **theKickstarter is
not an editor for your extensions** ! Whatever custom changes have
been made to the scripts of your new extension will be overwritten
when you write back the extension from the Kickstarter.

A good workflow for using the Kickstarter would be like this:

- Start by setting up all the features you need for your extension and
  write it with the Kickstarter.

- Begin to fill in dummy information in the database tables your
  extension contains. You will most likely find that you forgot
  something or misconfigured a database field. Since you have not yet
  done any changes to the files in the extension you can safely re-load
  the extension configuration (see above) and add the missing fields or
  whatever. Your dummy database content will not be affected by this
  operation.

- When you have tested that your database configuration works for your
  purpose you can begin to edit the PHP-scripts by hand (i.e.
  programming the extension itself). This is the "point-of-no-return"
  where you cannot safely return to the Kickstarter because you have now
  changed scripts manually.

