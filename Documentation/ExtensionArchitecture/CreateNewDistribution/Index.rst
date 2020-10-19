.. include:: ../../Includes.txt


.. _distribution:

===========================
Creating a new Distribution
===========================

This chapter describes the main steps in creating a new
distribution. It should not be considered as a full fledge
tutorial.


.. _distribution_concept:

Concept of Distributions
========================

Distributions are full TYPO3 CMS websites ready to be unpacked. They provide
an easy quick start for using TYPO3 CMS. The most well known distribution is
"The official Introduction Package". Distributions can most easily be installed
in the backend Extension Manager in "Get preconfigured distribution", it lists
all available distributions for the given core version.

A distribution is just an extension enriched with some further data that is
loaded or executed upon installing that extension. A distribution takes
care of the following parts:

- Deliver initial database data

- Deliver fileadmin files

- Deliver configuration for a package

- Hook into the process after saving configuration to
  trigger actions dependent on configuration values

- Deliver dependent extensions if needed (e.g., customized versions or
  extensions not available through TER)


.. _distribution-kickstart:

Kickstarting the Distribution
=============================

A distribution is a special kind of extension. The first step
is thus to create a new extension.
Start by registering an :ref:`extension key <extension-key>`,
which will be the unique identifier of your distribution.

Next create the :ref:`Extension declaration file <extension-declaration>` as usual,
except for the "category" property which must be set to
**distribution**.


.. _distribution-kickstart-image:

Configuring the Distribution Display in the EM
----------------------------------------------

You should provide two preview images for your distribution. Provide
a small 220x150 pixels for the list in the Extension Manager as
:file:`Resources/Public/Images/Distribution.png` and a larger 300x400 pixels
welcome image as :file:`Resources/Public/Images/DistributionWelcome.png`.
The welcome image is displayed in the distribution detail view inside the Extension Manager.


.. _distribution-kickstart-fileadmin:

Fileadmin Files
---------------

Create the following folder structure inside your extension:

- :file:`Initialisation`
- :file:`Initialisation/Files`

All the files inside that second folder will be copied to
:file:`fileadmin/<extkey>` during installation, where "extkey" is
the extension key of your distribution.

A good strategy on files (as followed by ext:introduction) is to construct
the distribution in a way that it can be unloaded after initial import
and removed from the file system.

To achieve that, when creating content for your distribution, all your
content related files (assets) should be located within :file:`fileadmin/<extkey>`
in the first place, and content elements or other records should reference
these files via FAL. A good export preset will then contain the content
related assets within your dump.

If there are files not directly referenced in tables selected for export
(for example ext:form .yml form configurations), you can locate them
within :file:`fileadmin/<extkey>`, too. Only those need to be copied to
:file:`Initialization/Files` - all other files referenced in database rows
will be within your export dump.

Note you should *not* end up with having all your site configuration
(TypoScript files, logos, css and so on) within :file:`fileadmin`. This
is considered bad practice. The main site setup should be an extension,
keep in mind that :file:`fileadmin` is for editors. In case of the
introduction distribution, the main site setup (templates, content elements, ...)
is included in the extension bootstrap_package, and ext:introduction has
a dependency to this. This way, ext:introduction only provides the
database dump and the asset files, while ext:bootstrap_package is the real
site setup. This ends up with only content related stuff being located in
:file:`fileadmin`, delivered by ext:introduction.


.. _distribution-kickstart-database:

Database Data
-------------

The database data is delivered as TYPO3 CMS export :file:`data.xml`.
Generate this file by exporting your whole installation
from the tree root with the import/export module.

.. warning::

    Do NOT include backend users in the dump! If you do, you end up
    having your user on other systems who loaded your distribution. Give
    the export a special check in this area. Having your backend user
    in the dump is most likely a security vulnerability of your distribution
    if that distribution is uploaded to the public.


The file has to be named :file:`data.xml` (or :file:`data.t3d`, where the .t3d
format is harder to maintain). The dump file must be located in the
:file:`Initialisation` folder.

It is also possible to have referenced files (images / media) in an own folder
called :file:`Initialisation/data.xml.files/` - a good export preset should
prepare that.

.. note::

    Due to core bugs, importing extracted files from standalone file folder
    only works since core version *8.7.10* and *9.1.0*. For older target
    core versions, files must not be extracted (tab Advanced options), but
    directly included in :file:`data.xml`.

    Another core issue prevents loading :file:`data.xml` if it is bigger than
    10MB. In this case the only option left is going with :file:`data.t3d`


Exporting the correct data can be a bit tricky to get right. It is a good
idea to create an "Export preset" within the Export module for that and deliver
an sql dump of that preset within the distribution. The introduction
distribution comes with a maintained
`sql dump <https://github.com/FriendsOfTYPO3/introduction/blob/master/Resources/Private/ImportExportPreset.sql>`_
that could be useful as kick start. Just load that row into table :php:`tx_impexp_presets` and adapt
to the needs of your distribution. The ext:introduction preset is configured as:

* Export db data as :file:`data.xml`
* Export only referenced FAL file relations into :file:`data.xml.files` directory,
  do not just export *all* files from fileadmin
* Do not export be_users (!)
* Do not export some other tables like sys_log and friends


.. _distribution-kickstart-configuration:

Distribution Configuration
--------------------------

A distribution is technically handled as an extension. Therefore you
can make use of all :ref:`configuration options <extension-options>` as needed.

After installing the extension, the event :ref:`AfterPackageActivationEvent<AfterPackageActivationEvent>` is
dispatched. You may use this to alter your website configuration (e.g. color
scheme) on the fly.


.. _distribution-kickstart-custom-dependencies:

Delivering Custom Dependencies
------------------------------

Normally extension dependencies are setup in the
:ref:`Extension declaration file <extension-declaration>`.

However sometimes, extensions are not available in the
*TYPO3 Extension Repository (TER)*, or you need to deliver a modified version.
Therefore, a distribution can act as its own extension repository.
Add unpacked extensions to :file:`Initialisation/Extensions/` to provide
dependencies. Your main extension has to be dependent on these
extensions as normal dependencies in :file:`ext_emconf.php`.

Extensions delivered inside an extension have the highest priority when extensions
need to be fetched.

.. caution::

  This will not overwrite extensions already present in the system.


.. _distribution-testing:

Test Your Distribution
======================

To test your distribution, simply copy your extension to an empty
TYPO3 CMS installation and try to install it from the Extension
Manager.

To test a distribution locally without uploading to TER, just install
a blank TYPO3 (last step in installer "Just get me to the Backend"),
then go to Extension Manager, select "Get extensions" once to let the
Extension Manager initialize the extension list (this is needed if your
distribution has dependencies to other extensions, for instance ext:introduction
depends on ext:bootstrap_package). Next, copy or move the distribution extension
to :file:`typo3conf/ext`, it will then show up in Extension Manager default
tab "Installed Extensions".

Install the distribution extension from there. The Extension Manager will then resolve
TER dependencies, loads the database dump and will handle the file operations.
Under the hood, this does the same as later installing the distribution
via "Get preconfigured distribution", when it has been uploaded or updated in
TER, with the only difference that you can provide and test the distribution
locally *without* uploading to TER first.

.. warning::

   It is not enough to clean all files and the page tree if you want to
   try again to install your distribution. Indeed, TYPO3 CMS remembers that it
   previously imported your distribution and will skip any known files and
   the database import. Make sure to clean the table "sys_registry" if you want
   to work around that, or, even better, install a new blank TYPO3 to test again.
   Tip: Optimize creating the empty TYPO3 instance with a script, you probably
   end up testing the import a couple of times until you are satisfied with the result.


.. _distribution-more-information:

More Information
================

The `introduction extension <https://github.com/FriendsOfTYPO3/introduction>`_ is a
good starting point to see how distributions are handled in practice. It also comes
with an *impexp* preset to easily export database data with correct settings and
dependencies.

Some additional backgrounds can be retrieved from the
`blueprint for this feature <http://wiki.typo3.org/Blueprints/DistributionManagement>`_.
