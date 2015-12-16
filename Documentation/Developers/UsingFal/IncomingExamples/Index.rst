
.. include:: ../../../Includes.txt



.. _using-fal-incoming-examples:

=================
Incoming Examples
=================

This is an initial collection of code examples.


Dealing with files
==================

See if a file already exists in the storage
-------------------------------------------

Code snippet from :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\TceformsUpdateWizard`::

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




Dealing with file references
============================

Create a file reference
-----------------------

Code snippet from :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\TceformsUpdateWizard::performUpdate`::

   if ($fileUid > 0) {
      $fields = array(
         // TODO add sorting/sorting_foreign
         'fieldname' => $fieldname,
         'table_local' => 'sys_file',
         // the sys_file_reference record should always placed on the same page
         // as the record to link to, see issue #46497
         'pid' => ($table === 'pages' ? $row['uid'] : $row['pid']),
         'uid_foreign' => $row['uid'],
         'uid_local' => $fileUid,
         'tablenames' => $table,
         'crdate' => time(),
         'tstamp' => time(),
         'sorting' => ($i + 256),
         'sorting_foreign' => $i,
      );
      if (isset($titleTextField)) {
         $fields['title'] = trim($titleTextContents[$i]);
      }
      if (isset($alternativeTextField)) {
         $fields['alternative'] = trim($alternativeTextContents[$i]);
      }
      if (isset($captionField)) {
         $fields['description'] = trim($captionContents[$i]);
      }
      if (isset($linkField)) {
         $fields['link'] = trim($linkContents[$i]);
      }
      $this->database->exec_INSERTquery('sys_file_reference', $fields);
      $queries[] = str_replace(LF, ' ', $this->database->debug_lastBuiltQuery);
      ++$i;
   }

