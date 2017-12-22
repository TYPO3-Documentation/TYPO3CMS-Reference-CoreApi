.. include:: ../../../Includes.txt


.. _services-using-services-subtypes:

Use with subtypes
^^^^^^^^^^^^^^^^^

A service can also be requested for not just a type, but a subtype
too:

.. code-block:: php

   // Find a service for a file type
   if (is_object($serviceObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('metaExtract', $fileType))) {
           $serviceObj->setInputFile($absFile, $fileType);
           if ($serviceObj->process('', '', array('meta' => $meta)) > 0 && (is_array($svmeta = $serviceObj->getOutput()))) {
                   $meta = $svmeta;
           }
   }

In this example a service type "metaExtract" is requested for a
specific subtype corresponding to some file's type. With the returned
instance, it then proceeds to retrieving whatever possible meta data
from the file.

If several services are available for the same subtype, the one with
the highest priority (or quality if priority are equals) will be used.

