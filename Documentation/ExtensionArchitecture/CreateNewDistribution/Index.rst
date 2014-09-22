.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _distribution-create-new:

Creating a new distribution
===========================

This chapter is not a full tutorial about how to create a distribution.
It only aims to be a list of steps to perform and key information
to remember.

.. _distribution_concept:

Concept of distributions
------------------------

Distribution are full TYPO3 CMS websites to be unpacked. They provide
an easy quickstart into using TYPO3 CMS.

The distribution takes care of the following parts:

- Deliver initial database data

- Deliver fileadmin files

- Deliver configuration for a package

- Be able to hook into the process after saving configuration to
  trigger actions dependent on configuration values
  (for example color selection in the old introduction package)

- Deliver custom dependent extensions (customized versions or
  extensions not available through TER)


.. _distribution-kickstart:

Kickstarting the distribution
-----------------------------

You need to create an extension, because a distribution is technically
just an extension.
That means you have to register an :ref:`extension-key`. This is the
unique identifier for your distribution.

Once you have an extension key, you can create a new folder with the
name of your extension key.
Inside that folder you need to create the :ref:`extension-declaration`
file. Inside that file, you have to set the extension category to
**distribution**. Here you must also define your dependencies.

.. _distribution-kickstart:

Configuring the distribution display in the EM
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You should provide two preview images for your distribution. Provide
the a small 220x150 pixels for the list in the extension manager in
``Resources/Public/Images/Distribution.png`` and a bigger welcome
image in ``Resources/Public/Images/DistributionWelcome.png`` with
300x400 pixels. The welcome image is displayed in the distribution
detail view inside the extension manager.

.. _distribution-kickstart-fileadmin:

Fileadmin files
^^^^^^^^^^^^^^^
Create a folder ``Initialisation``.
Create a folder ``Files`` inside ``Initialisation`` such that the
resulting path is ``Initialisation\Files\``. All files side this folder
will be copied into ``fileadmin\<extkey>\`` during the installation.
``<extkey>`` is the extension key you choose as a unique identifier.

.. info::
   This means you have to make sure to only have files inside
   ``fileadmin\`` if you have them inside ``fileadmin\<extkey>``.
   You need to ensure this before exporting your database.

Copy all files and folders from ``fileadmin\<extkey>`` to
``Initialisation\Files`` to have them available inside the
distribution.

.. _distribution-kickstart-database:

Database data
^^^^^^^^^^^^^

The database data is delivered as TYPO3 CMS export ``data.t3d``.
Therefore export it from the tree root with the import/export
module. Make sure to include all tables in the export.

The file has to be name ``data.t3d`` and must copied inside the
``Initialisation`` folder.

.. _distribution-kickstart-custom-dependencies:

Delivering custom dependencies
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Normally extension dependencies are setup in the
:ref:`ext_emconf.php extension-declaration` file.

However sometimes, extensions are not available in the
*TYPO3 Extension Repository (TER)*.
Therefore a distribution can act as its own extension repository.
Add unpacked extensions to ``Initialisation/Extensions/`` to provide
dependencies. Your main extension has to be dependent on these
extension as normal dependencies in ext_emconf. Extensions delivered
inside an extension have the highest priority when extensions need to
be fetched.

.. warning::
   Caution, these will not overwrite extensions already present in the system.


.. _distribution-testing:

Test your distribution
----------------------

You can test your distribution by copying the whole folder (named like
your extension key) to ``typo3conf/ext/`` of an empty TYPO3 CMS
installation. Then you can install your distribution with the extension
manager.

.. warning::
   It is not enough to clean all files and the page tree if you want to
   retry your distribution installation. TYPO3 CMS remembers that it
   imported your distribution before and will skip any know files.
   Make sure to clean the table ``sys_registry`` if you want to work
   around that.


.. _distribution-more-information:

More information
^^^^^^^^^^^^^^^^

Some additional backgrounds can be retrieved from the `blueprint`_.

.. _blueprint: http://wiki.typo3.org/Blueprints/DistributionManagement

