.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _distribution:

Creating a new distribution
===========================

This chapter describes the main steps in creating a new
distribution. It should not be considered as a full fledge
tutorial.


.. _distribution_concept:

Concept of distributions
------------------------

Distributions are full TYPO3 CMS websites ready to be unpacked. They provide
an easy quickstart for using TYPO3 CMS.

A distribution takes care of the following parts:

- Deliver initial database data

- Deliver fileadmin files

- Deliver configuration for a package

- Hook into the process after saving configuration to
  trigger actions dependent on configuration values

- Deliver dependent extensions (e.g., customized versions or
  extensions not available through TER)


.. _distribution-kickstart:

Kickstarting the distribution
-----------------------------

A distribution is a special kind of extension. The first step
is thus to create a new extension.
Start by registering an :ref:`extension key <extension-key>`,
which will be the unique identifier of your distribution.

Next create the :ref:`Extension declaration file <extension-declaration>` as usual,
except for the "category" property which must be set to
**distribution**.


.. _distribution-kickstart-image:

Configuring the distribution display in the EM
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You should provide two preview images for your distribution. Provide
a small 220x150 pixels for the list in the extension manager as
:file:`Resources/Public/Images/Distribution.png` and a larger 300x400 pixels
welcome image as :file:`Resources/Public/Images/DistributionWelcome.png`.
The welcome image is displayed in the distribution detail view inside the extension manager.


.. _distribution-kickstart-fileadmin:

Fileadmin files
^^^^^^^^^^^^^^^

Create the following folder structure inside your extension:

- :file:`Initialisation`
- :file:`Initialisation/Files`

All the files inside that second folder will be copied to
:file:`fileadmin/<extkey>` during installation, where "extkey" is
the extension key of your distribution.


.. _distribution-kickstart-database:

Database data
^^^^^^^^^^^^^

The database data is delivered as TYPO3 CMS export :file:`data.t3d`.
Generate this file by exporting your whole installation
from the tree root with the import/export
module. Make sure to include all tables in the export.

The file has to be name :file:`data.t3d` and must be located in the
:file:`Initialisation` folder.


.. _distribution-kickstart-configuration:

Distribution configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^

A distribution is technically handled as an extension. Therefore your
can make use of all :ref:`configuration options <extension-options>` as needed.

After saving the configuration, the signal
:code:`afterExtensionConfigurationWrite` is dispatched. You may use this
to alter your website configuration (e.g. color scheme) on the fly.


.. _distribution-kickstart-custom-dependencies:

Delivering custom dependencies
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Normally extension dependencies are setup in the
:ref:`Extension declaration file <extension-declaration>`.

However sometimes, extensions are not available in the
*TYPO3 Extension Repository (TER)*.
Therefore, a distribution can act as its own extension repository.
Add unpacked extensions to :file:`Initialisation/Extensions/` to provide
dependencies. Your main extension has to be dependent on these
extension as normal dependencies in :file:`ext_emconf.php`.

Extensions delivered inside an extension have the highest priority when extensions
need to be fetched.

.. caution::

  This will not overwrite extensions already present in the system.


.. _distribution-testing:

Test your distribution
----------------------

To test your distribution, simply copy your extension to an empty
TYPO3 CMS installation and try to install it from the Extension
Manager.

.. warning::

   It is not enough to clean all files and the page tree if you want to
   try again to install your distribution. Indeed, TYPO3 CMS remembers that it
   previously imported your distribution and will skip any known files.
   Make sure to clean the table "sys_registry" if you want to work
   around that.


.. _distribution-more-information:

More information
----------------

Some additional backgrounds can be retrieved from the
`blueprint for this feature <http://wiki.typo3.org/Blueprints/DistributionManagement>`_.
