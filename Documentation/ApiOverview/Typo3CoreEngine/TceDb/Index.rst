.. include:: /Includes.rst.txt
.. index::
   DataHandler; Record / commit route
   SimpleDataHandlerController
.. _tce-db-api:
.. _record-commit-route:

==========================
The "/record/commit" Route
==========================

This route is a gateway for posting form data to the
:php:`\TYPO3\CMS\Backend\Controller\SimpleDataHandlerController`.

You can send data to this file either as GET or POST vars where POST
takes precedence. The variable names you can use are:

.. t3-field-list-table::
 :header-rows: 1

 - :Variable,20: GP var name
   :Type,20: Data type
   :Description,60: Description


 - :Variable:
         data
   :Type:
         array
   :Description:
         Data array on the form :code:`[tablename][uid][fieldname] = value`.

         Typically it comes from a POST form which submits a form field like
         :code:`<input name="data[tt_content][123][header]" value="This is the
         headline" />`.


 - :Variable:
         cmd
   :Type:
         array
   :Description:
         Command array on the form :code:`[tablename][uid][command] = value`. This
         array may get additional data set internally based on clipboard
         commands send in CB var!

         Typically this comes from GET vars passed to the script like
         :code:`&cmd[tt\_content][123][delete]=1` which will delete Content Element
         with UID 123.


 - :Variable:
         cacheCmd
   :Type:
         string
   :Description:
         Cache command sent to :code:`->clear_cacheCmd`


 - :Variable:
         redirect
   :Type:
         string
   :Description:
         Redirect URL. Script will redirect to this location after performing
         operations (unless errors has occurred)


 - :Variable:
         flags
   :Type:
         array
   :Description:
         Accepts options to be set in `TCE`:pn: object. Currently it supports
         "reverseOrder" (boolean).


 - :Variable:
         mirror
   :Type:
         array
   :Description:
         Example: :code:`[mirror][table][11] = '22,33'` will look for content in
         :code:`[data][table][11]` and copy it to :code:`[data][table][22]` and
         :code:`[data][table][33]`.


 - :Variable:
         CB
   :Type:
         array
   :Description:
         Clipboard command array. May trigger changes in "cmd".


 - :Variable:
         vC
   :Type:
         string
   :Description:
         Verification code
