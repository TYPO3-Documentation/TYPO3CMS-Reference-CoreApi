
.. include:: ../../../Includes.txt



.. _using-fal-incoming-examples:

=================
Incoming Examples
=================

This is an initial collection of code examples.


With Files
==========

See if a file already exists in the storage
-------------------------------------------

::

   $fileSha1 = sha1_file($sourcePath);

   $existingFileRecord = $this->database->exec_SELECTgetSingleRow(
      'uid',
      'sys_file',
      'sha1=' . $this->database->fullQuoteStr($fileSha1, 'sys_file') . ' AND storage=' . $storageUid
   );
   if (is_array($existingFileRecord)) {
      $fileUid = $existingFileRecord['uid'];
   } else {
      $fileUid = NULL;
   }

