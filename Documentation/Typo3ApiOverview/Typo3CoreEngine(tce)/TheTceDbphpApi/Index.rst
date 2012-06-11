

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


The "tce\_db.php" API
^^^^^^^^^^^^^^^^^^^^^

This script is a gateway for POST forms to class.t3lib\_TCEmain. It
has historically been  *the* script to which data was posted when you
wanted to update something in the database.

Today it is used for editing by only a few scripts, actually only the
"Quick Edit" module in "Web>Page" (frontend). The standard forms you
find in TYPO3 are normally rendered and handled by "alt\_doc.php"
which includes t3lib\_TCEmain on its own.

For commands it is still used from various locations.

You can send data to this file either as GET or POST vars where POST
takes precedence. The variable names you can use are:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   GP var name
         GP var name:
   
   Data type
         Data type
   
   Description
         Description


.. container:: table-row

   GP var name
         data
   
   Data type
         array
   
   Description
         Data array on the form [tablename][uid][fieldname] = value
         
         Typically it comes from a POST form which submits a form field like
         <input name="data[tt\_content][123][header]" value="This is the
         headline" />


.. container:: table-row

   GP var name
         cmd
   
   Data type
         array
   
   Description
         Command array on the form [tablename][uid][command] = value. This
         array may get additional data set internally based on clipboard
         commands send in CB var!
         
         Typically this comes from GET vars passed to the script like
         "&cmd[tt\_content][123][delete]=1" which will delete Content Element
         with UID 123


.. container:: table-row

   GP var name
         cacheCmd
   
   Data type
         string
   
   Description
         Cache command sent to ->clear\_cacheCmd


.. container:: table-row

   GP var name
         redirect
   
   Data type
         string
   
   Description
         Redirect URL. Script will redirect to this location after performing
         operations (unless errors has occurred)


.. container:: table-row

   GP var name
         flags
   
   Data type
         array
   
   Description
         Accepts options to be set in TCE object. Currently it supports
         "reverseOrder" (boolean).


.. container:: table-row

   GP var name
         mirror
   
   Data type
         array
   
   Description
         Example: [mirror][table][11] = '22,33' will look for content in
         [data][table][11] and copy it to [data][table][22] and
         [data][table][33]


.. container:: table-row

   GP var name
         prErr
   
   Data type
         boolean
   
   Description
         If set, errors will be printed on screen instead of redirection.
         Should always be used, otherwise you will see no errors if they
         happen.


.. container:: table-row

   GP var name
         CB
   
   Data type
         array
   
   Description
         Clipboard command array. May trigger changes in "cmd"


.. container:: table-row

   GP var name
         vC
   
   Data type
         string
   
   Description
         Verification code


.. container:: table-row

   GP var name
         uPT
   
   Data type
         string
   
   Description
         Update Page Tree Trigger. If set and the manipulated records are pages
         then the update page tree signal will be set.


.. ###### END~OF~TABLE ######

