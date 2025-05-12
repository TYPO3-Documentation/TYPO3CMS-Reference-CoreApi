:navigation-title: Tuning

.. include:: /Includes.rst.txt

.. index:: tuning
.. _tunetypo3:

============
Tuning TYPO3
============

This chapter contains information on how to configure and optimize the infrastructure
running TYPO3.

..  attention::
    Information on other methods to tune TYPO3 is currently scattered or missing.

    Please `Contribute to the TYPO3 documentation <https://docs.typo3.org/permalink/h2document:docs-official-workflow-methods>`_

..  _opcache:

OPcache
=======

It is recommended that OPcache be enabled on the web server running TYPO3. OPcache's
default settings will provide significant performance improvements; however there are
some changes you can make to help further improve stability and performance. In addition
enabling certain features in OPcache can lead to performance degradation.

..  _opcache-enable:

Enabling OPcache
----------------

.. code-block:: ini
  :caption: php.ini

  opcache.enable=1
  opcache.revalidate_freq=30
  opcache.revalidate_path=0

..  _opcache-tune:

Tuning OPcache
--------------

Below is list a of OPcache features with information on how they can impact TYPO3's performance.

.. confval:: opcache.save_comments

 :Default: 1
 :Recommended: 1

 Setting this to 0 may improve performance but some parts of TYPO3 (including Extbase)
 rely on information stored in phpDoc comments to function correctly.

.. confval:: opcache.use_cwd

 :Default: 1
 :Recommended: 1

 Setting the value to 0 may cause problems in certain applications because files
 that have the same name may get mixed up due to the complete path of the file not
 being stored as a key. TYPO3 works with absolute paths so this would
 return no improvements to performance.

.. confval:: opcache.validate_timestamps

 :Default: 1
 :Recommended: 1

 While setting this to 0 may speed up performance, you **must** make sure to
 flush opcache whenever changes are made to the PHP scripts or they will not
 be updated in OPcache. This can be achieved by using a proper deployment
 pipeline. Additionally, some files can be added to the blacklist, see `opcache.blacklist_filename` for more information.

.. confval:: opcache.revalidate_freq

 :Default: 2
 :Recommended: 30

 Setting this to a high value can improve performance but shares the same issue
 when setting `validate_timestamps` to 0.

.. confval:: opcache.revalidate_path

 :Default: 1
 :Recommended: 0

 Setting this value to 0 should be safe with TYPO3. This may be a problem if
 relative path names are used to load scripts and if the same file exists several
 times in the include path.

.. confval:: opcache.max_accelerated_files

 :Default: 10000
 :Recommended: 10000

 The default setting should be enough for TYPO3, but this depends
 on the number of additional scripts that need to be loaded by the system.

For more information on OPcache visit the `Official PHP documentation <https://www.php.net/manual/en/opcache.configuration.php>`__.
