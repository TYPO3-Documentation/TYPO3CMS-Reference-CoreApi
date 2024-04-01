..  include:: /Includes.rst.txt
..  index::
    DataHandler; Record / commit route
    SimpleDataHandlerController
..  _tce-db-api:
..  _record-commit-route:

==========================
The "/record/commit" route
==========================

This route is a gateway for posting form data to the
:php:`\TYPO3\CMS\Backend\Controller\SimpleDataHandlerController`.

You can send data to this file either as GET or POST vars where POST
takes precedence. The variable names you can use are:

..  confval:: data
    :name: datahandler-commit-data
    :Data type: array

    Data array on the form `[tablename][uid][fieldname] = value`.

    Typically it comes from a POST form which submits a form field like
    :html:`<input name="data[tt_content][123][header]" value="This is the
    headline">`.


..  confval:: cmd
    :name: datahandler-commit-cmd
    :Data type: array

    Command array on the form `[tablename][uid][command] = value`. This
    array may get additional data set internally based on clipboard
    commands send in :confval:`datahandler-commit-cb` var!

    Typically this comes from GET vars passed to the script like
    `&cmd[tt_content][123][delete]=1` which will delete the content
    element with UID 123.


..  confval:: cacheCmd
    :name: datahandler-commit-cacheCmd
    :Data type: string

    Cache command sent to :php:`DataHandler->clear_cacheCmd()`.


..  confval:: redirect
    :name: datahandler-commit-redirect
    :Data type: string

    Redirect URL. The script will redirect to this location after performing
    operations (unless errors has occurred).


..  confval:: flags
    :name: datahandler-commit-flags
    :Data type: array

    Accepts options to be set in DataHandler object. Currently, it supports
    "reverseOrder" (boolean).


..  confval:: mirror
    :name: datahandler-commit-mirror
    :Data type: array

    Example: `[mirror][table][11] = '22,33'` will look for content in
    `[data][table][11]` and copy it to `[data][table][22]` and
    `[data][table][33]`.


..  confval:: CB
    :name: datahandler-commit-cb
    :Data type: array

    Clipboard command array. May trigger changes in "cmd".


..  confval:: vC
    :name: datahandler-commit-vc
    :Data type: string

    Verification code.
