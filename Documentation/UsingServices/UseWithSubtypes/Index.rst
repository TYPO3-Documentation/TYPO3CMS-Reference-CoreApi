.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Use with subtypes
^^^^^^^^^^^^^^^^^

A service can also be requested for not just a type, but a subtype
too::

      // find a service for a file type
   if (is_object($serviceObj = t3lib_div::makeInstanceService('metaExtract',$fileType))) {
           $serviceObj->setInputFile($absFile, $fileType);
           if ($serviceObj->process('', '', array('meta' => $meta)) > 0
                           && (is_array($svmeta = $serviceObj->getOutput()))) {
                   $meta = $svmeta;
           }
   }

In this example a service type "metaExtract" is requested for a
specific subtype corresponding some file's type. With the returned
instance, it then proceeds to retrieving whatever possible meta data
from the file.

If several services are available for the same subtype, the one with
the highest priority (or quality if priority are equals) will be used.

