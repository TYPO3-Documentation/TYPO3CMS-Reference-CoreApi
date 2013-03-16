.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: Images.txt


Links to edit records
^^^^^^^^^^^^^^^^^^^^^

Quite often in your backend modules you might like to create a link to
edit a record. This is easily done with an API function call to
:code:`\TYPO3\CMS\Backend\Utility\BackendUtility::editOnClick()`. This script will create an onclick-
JavaScript event linking you to the "alt\_doc.php" script in the
"PATH\_typo3" directory.

All you need to do is prepare GET parameters for the "alt\_doc.php"
script. Please look inside of "alt\_doc.php" for more details of
possible GET vars you can use and what they mean. In this example I
have shown the most typical options.

The result of the code listing will be three links like these:

|img-31| The code listing looks like this::

      1: $editUid = 1135;
      2: $editTable = 'pages';
      3:
      4:     // Edit whole record:
      5: $params = '&edit[' . $editTable . '][' . $editUid . ']=edit';
      6: $output.= '<a href="#" onclick="' . htmlspecialchars(\TYPO3\CMS\Backend\Utility\BackendUtility::editOnClick($params,$GLOBALS['BACK_PATH'])) . '">' .
      7:         '<img'.\TYPO3\CMS\Backend\Utility\IconUtility::skinImg($GLOBALS['BACK_PATH'], 'gfx/edit2.gif', 'width="11" height="12"') . ' title="Edit me" border="0" alt="" />'.
      8:         'Edit record ' . $editUid . ' from the "' . $editTable . '" table' .
      9:         '</a><br/><br/>';
     10:
     11:     // Edit only "title" and "hidden" fields from record:
     12: $params = '&edit[' . $editTable . '][' . $editUid.']=edit&columnsOnly=title,hidden';
     13: $output .= '<a href="#" onclick="' . htmlspecialchars(\TYPO3\CMS\Backend\Utility\BackendUtility::editOnClick($params,$GLOBALS['BACK_PATH'])) . '">'.
     14:         'Edit "title" and "hidden" fields from record ' . $editUid . ' from the "' . $editTable . '" table' .
     15:         '</a><br/><br/>';
     16:
     17:     // Create new "Content Element" record in PID 1135
     18: $params = '&edit[tt_content][' . $editUid . ']=new&defVals[tt_content][header]=New%20Element';
     19: $output .= '<a href="#" onclick="' . htmlspecialchars(\TYPO3\CMS\Backend\Utility\BackendUtility::editOnClick($params,$GLOBALS['BACK_PATH'])) . '">' .
     20:         'Create new Content Element inside page ' . $editUid.
     21:         '</a><br/>';


Editing a record
""""""""""""""""

In line 5 you see the basic GET parameter you need to set up to edit a
record. You need to know the database table name, record uid in
advance. The syntax is "&edit[  *tablename* ][  *uid* ]=edit". You can
specify as many tables and uids you like and you will get them all in
one single form! The "uid" variable can even be a comma list of uids
(short way of editing more records from the same table at once).

The lines 5-9 produces a link which shows this form:


|img-32| Editing only a few fields from a record
""""""""""""""""""""""""""""""""""""""""""""""""

Lines 11-15 creates the same link but with additional information that
only the field names "title" and "hidden" should be edited! That is
done by adding the GET parameters "&columnsOnly=title,hidden". This
means the form will look like this:


|img-33| Creating a form for new elements
"""""""""""""""""""""""""""""""""""""""""

Lines 17-21 creates a link which will make a new content element
inside the page with "pid" 1135. The syntax for creating new records
is "&edit[  *table\_name\_of\_new\_record* ][  *pid\_reference*
]=new". The pid reference is special: If it is a negative value it
points to another record from the same table  *after which* the new
record should be created. If it is positive or zero it just points to
the page id where the record should be created (as the top element).

Another feature is that a custom default value for the header field is
automatically passed along. This is done by the additional GET
parameter "&defVals[tt\_content][header]=New%20Element" and you can
see how the Header field is pre-filled with this value below.

The result of the "create new" will be this form.


