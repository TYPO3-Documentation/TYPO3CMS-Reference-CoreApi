.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: Images.txt


Accessing the clipboard
^^^^^^^^^^^^^^^^^^^^^^^

You can easily access the internal clipboard in TYPO3 from your
backend modules.

.. code-block:: php
   :linenos:

   // Start clipboard
   $clipObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Clipboard\\Clipboard');
   // Initialize - reads the clipboard content from the user session
   $clipObj->initializeClipboard();
   debug($clipObj->clipData);

- Lines 1-4 initialize the clipboard library

- Line 5 outputs the content of the internal variables, ->clipData. That
  will look like what you see below:

|img-23|

This tells us what objects are registered on the "normal" tab
(page record with id 1146 in "copy" mode) and the numeric tabs (can
contain more than one element). The current clipboard (Pad 2 active)
looks like this:

|img-24|

The correct way of accessing clipboard content is to the
method, elFromTable(), in the clipboard object. ::

       debug($clipObj->elFromTable('_FILE'), 'Files available:');
       debug($clipObj->elFromTable('pages'), 'Page records:');
       $clipObj->setCurrentPad('normal');
       echo 'Changed to "normal" pad...';
       debug($clipObj->elFromTable('_FILE'), 'Files available:');
       debug($clipObj->elFromTable('pages'), 'Page records:');

Here we first try to get all files and then all page records on the
current pad (which is pad 2). Then we change to the "Normal" pad, call
the elFromTable() method again and output the results. The output
shows that in the first attempt we get the list of files but no page
records while in the second attempt after having changed to the normal
pad we will get no files but the page record on the normal pad in
return:


|img-25|

Setting elements on the clipboard
"""""""""""""""""""""""""""""""""

This is too complicated to describe in detail. The following
codelisting is from the Web > List module where selections for the
clipboard is posted from a form and registered. ::

       // Clipboard actions are handled:
   $CB = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('CB');    // CB is the clipboard command array
   if ($this->cmd=='setCB') {
           // CBH is all the fields selected for the clipboard, CBC is the checkbox fields which were checked. By merging we get a full array of checked/unchecked elements
           // This is set to the 'el' array of the CB after being parsed so only the table in question is registered.
       $CB['el'] = $dblist->clipObj->cleanUpCBC(array_merge(\TYPO3\CMS\Core\Utility\GeneralUtility::_POST('CBH'), \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('CBC')), $this->cmd_table);
   }
   if (!$this->MOD_SETTINGS['clipBoard']) {
           $CB['setP'] = 'normal';    // If the clipboard is NOT shown, set the pad to 'normal'.
   }
   $dblist->clipObj->setCmd($CB);        // Execute commands.
   $dblist->clipObj->cleanCurrent();    // Clean up pad
   $dblist->clipObj->endClipboard();    // Save the clipboard content


