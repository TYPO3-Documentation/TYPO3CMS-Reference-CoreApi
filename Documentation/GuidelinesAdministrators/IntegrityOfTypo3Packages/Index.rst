.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _integrity-packages:

Integrity of TYPO3 packages
^^^^^^^^^^^^^^^^^^^^^^^^^^^

In order to ensure that the downloaded TYPO3 package is an official
package released by the TYPO3 developers, compare the MD5 checksum of
the downloaded package with the checksum stated on the TYPO3 website,
before you extract/install TYPO3. You find the MD5 checksums in the
Wiki (e.g. `http://wiki.typo3.org/wiki/TYPO3\_4.6.0
<http://wiki.typo3.org/wiki/TYPO3_4.5.6>`_ for the official TYPO3
version 4.6.0 packages).

Be careful when using pre-installed or pre-configured packages by
other vendors: due to the nature and complexity of TYPO3 the CMS
requires configuration. Some vendors offer download-able packages,
sometimes including components such as Apache, MySQL, PHP and TYPO3,
easy to extract and ready to launch. This is a comfortable way to set
up a test or development environment very quickly but it is difficult
to verify the integrity of the components – for example the integrity
of TYPO3.

A similar thing applies to web environments offered by hosting
companies: system images sometimes include a bunch of software
packages, including a CMS. It depends on the specific project and if
you can trust the provider of these pre-installed images, systems,
packages – but if you are in doubt, use the official TYPO3 packages
only. For a production site in particular, you should trust the source
code published at typo3.org only.

