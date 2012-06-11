

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


System, Global and Local extensions
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The files for an extension are located in a folder named by the
*extension key* . The location of this folder can be either inside
typo3/sysext/, typo3/ext/ or typo3conf/ext/.

The extension *must* be programmed so that it does automatically
detect where it is located and can work from all three locations. If
it is not possible to make the extension that flexible, it is possible
to lock its installation requirement to one of these locations in the
emconf.php file (see “lockType”)

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Type
         Type
   
   Path
         Path
   
   Description
         Description


.. container:: table-row

   Type
         Local
   
   Path
         typo3conf/ext/
   
   Description
         This is where to put extensions  *which are lo* cal for a particular
         TYPO3 installation. The typo3conf/ dir is always local, containing
         local configuration (e.g.  *loc* alconf.php), local modules etc. If
         you put an extension here it will be available for a single TYPO3
         installation only. This is a “per-database” way to install an
         extension.
         
         **Notice about symlinking:** Local extension can successfully be
         symlinked to other local extensions on a server as long as they are
         running under the same TYPO3 source version (which would typically
         also be symlinked). This method is useful for maintenance of the same
         local extension running under several sites on a server.


.. container:: table-row

   Type
         Global
   
   Path
         typo3/ext/
   
   Description
         This is a “per-server” way to install an extension; they are global
         for the TYPO3 source code on the web server. These extensions will be
         available for any TYPO3 installation sharing the source code.
         
         **Notice on distribution:**
         
         As of version 4.0, TYPO3 is no longer distributed with a fixed set of
         global extensions. In previous versions these were distributed for
         reasons like popularity and sometimes history.


.. container:: table-row

   Type
         System
   
   Path
         typo3/sysext/
   
   Description
         This is system default extensions which cannot and should not be
         updated by the EM. They are distributed with TYPO3 core source code
         and generally understood to be a part of the core system.


.. ###### END~OF~TABLE ######


Loading precedence
""""""""""""""""""

Local extensions take precedence which means that if an extension
exists both in typo3conf/ext/ and typo3/ext/ the one in typo3conf/ext/
is loaded. Likewise  *global* extension takes precedence over
*system* extensions. This means that extensions are loaded in the
order of priority local-global-system.

In effect you can therefore have - say - a “stable” version of an
extension installed in the global dir (typo3/ext/) which is used by
all your projects on a server sharing source code, but on a single
experimental project you can import the same extension in a newer
“experimental” version and for that particular project the locally
available extension will be used instead.

