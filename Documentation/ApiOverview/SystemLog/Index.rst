.. include:: /Includes.rst.txt

.. _syslog:

========================
System Log
========================

.. warning::

   A :ref:`new logging API <logging>` was introduced in TYPO3 CMS 6.0. It should be used by extension
   authors starting with TYPO3 v9 LTS. The following section is here as legacy reference,
   but should not be used in installations with TYPO3 >= 9.

Writing to the system log is done using the backend user object,
which writes to the "sys_log" table::

   $this->BE_USER->writelog($type, $action, $error, $details_nr, $details, $data, $table, $recuid, $recpid,$event_pid, $NEWid);


Here is a description of the arguments to this function call,
and corresponding database fields in table "sys\_log":

.. t3-field-list-table::
 :header-rows: 1

 - :Field,15: Field
   :Type,15: Type
   :Var,15: Var
   :Description,55: Description


 - :Field:
         type
   :Type:
         tinyint
   :Var:
         $type
   :Description:
         Value telling which module in TYPO3 set the log entry. The type values
         are paired with an action-integer which is telling in more detail what
         the event was. Here type and action values are arranged hierarchically
         (type on first level, action on second level):

         |

         - 1 : :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` ("TYPO3 Core Engine" where database records are
           manipulated)

           - Action values are:

             - 0 = no category

             - 1 = new record

             - 2 = update record

             - 3 = delete record

             - 4 = move record

             - 5 = check/evaluate

         - 2 : "tce\_file" (File handling in fileadmin/ and absolute filemounts)

           - Action values are for various file handling types like upload, rename,
             edit etc.

         - 3 : System (e.g. sys\_history save)

         - 4 : Modules: This is the mode you may use for extensions having
           backend module functionality. Probably you would like to use
           :code:`BE_USER->writelog()` for your extensions.

         - 254 : Personal settings changed

         - 255 : Login or Logout action

           - 1 = login

           - 2 = logout

           - 3 = failed login (+ errorcode 3)

           - 4 = failure\_warning\_email sent


 - :Field:
         action
   :Type:
         tinyint
   :Var:
         $action
   :Description:
         *See "type" above*

         When not available, use value "0"


 - :Field:
         error
   :Type:
         tinyint
   :Var:
         $error
   :Description:
         Error level:

         - 0 = message, a notice of an action that happened.

         - 1 = error, typically a permission problem for the user

         - 2 = System Error, something which should not happen for technical
           reasons.

         - 3 = Security notice, like login failures


 - :Field:
         details\_nr
   :Type:
         tinyint
   :Var:
         $details\_nr
   :Description:
         Number of "detail" message. This number should be unique for the
         combination of type/action

         -1 is a temporary detail number you can use while developing and error
         messages are not fixed yet.

         0 is a value that means the message is not supposed to be translated

         >= 1 means the message is fixed and ready for translation.


 - :Field:
         details
   :Type:
         tinytext
   :Var:
         $details
   :Description:
         The log message text (in english). By identification through
         type/action/details\_nr this can be translated through the
         localization system.

         If you insert "%s" markers in the details message and set :code:`$data` to an
         array the first 5 entries (keys 0-4) from :code:`$data` will substitute the
         markers sequentially (using sprintf).


 - :Field:
         log\_data
   :Type:
         tinyblob
   :Var:
         $data
   :Description:
         Data that follows the log entry. Can be an array. See "details" for
         more info.


 - :Field:
         tablename
   :Type:
         varchar(40)
   :Var:
         $table
   :Description:
         Table name. Special field used by tce\_main.php.


 - :Field:
         recuid
   :Type:
         int
   :Var:
         $recuid
   :Description:
         Record UID. Special field used by tce\_main.php.


 - :Field:
         recpid
   :Type:
         int
   :Var:
         $recpid
   :Description:
         Record PID. Special field used by tce\_main.php. [OBSOLETE; not used
         anymore.]


 - :Field:
         event\_pid
   :Type:
         int
   :Var:
         $event\_pid
   :Description:
         The page ID (pid) where the event occurred. Used to select log-content
         for specific pages.


 - :Field:
         NEWid
   :Type:
         varchar(20)
   :Var:
         $NEWid
   :Description:
         Special field used by tce\_main.php. NEWid string of newly created
         records.


 - :Field:
         tstamp
   :Type:
         int
   :Var:
         \-
   :Description:
         EXEC\_TIME of event, UNIX time in seconds.


 - :Field:
         uid
   :Type:
         int
   :Var:
         \-
   :Description:
         Unique ID for log entry, automatically inserted


 - :Field:
         userid
   :Type:
         int
   :Var:
         \-
   :Description:
         User ID of backend user, automatically set for you


 - :Field:
         IP
   :Type:
         varchar(39)
   :Var:
         \-
   :Description:
         REMOTE\_ADDR of client


 - :Field:
         workspace
   :Type:
         int
   :Var:
         \-
   :Description:
         Workspace ID


