.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Service API
^^^^^^^^^^^

All service classes must inherit from the base service class
:code:`t3lib\_svbase` , unless the service type provides a specific
base class (authentication services, for example, inherit from
:code:`tx\_sv\_authbase` instead). These specific classes should
normally themselves extend :code:`t3lib\_svbase` . This class provides
a large number of important or useful methods which are described
below, grouped by type of usage.


Getter methods for service information
""""""""""""""""""""""""""""""""""""""

Most of the below methods are quite obvious, except for
:code:`getServiceOption()` .

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         getServiceInfo

   Description
         Returns the array containing the service's properties


.. container:: table-row

   Method
         getServiceKey

   Description
         Returns the service's key


.. container:: table-row

   Method
         getServiceTitle

   Description
         Returns the service's title


.. container:: table-row

   Method
         getServiceOption

   Description
         This method is used to retrieve the value of a service option, as
         defined in the :code:`$TYPO3\_CONF\_VARS['SVCONF']` array. It will
         take into account possible default values as described in the “Service
         configuration” chapter above.


.. ###### END~OF~TABLE ######

The :code:`getServiceOption()` method requires more explanations.
Imagine your service has an option called “ignoreBozo”. To retrieve it
in a proper way, you should not access
:code:`$TYPO3\_CONF\_VARS['SVCONF']` directly, but use
:code:`getServiceOption()` instead. In its simplest form, it will look
like this (inside your service's code)::

   $ignoreBozo = $this->getServiceOption('ignoreBozo');

This will retrieve the value of the “ignoreBozo” option for your
specific service, if defined. If not, it will try to find a value in
the default configuration. Additional call parameters can be added:

- the second parameter is a default value to be used if no value was
  found at all (including in the default configuration)

- the third parameter can be used to temporarily switch off the usage of
  the default configuration.

This allows for a lot of flexibility.


Error handling
""""""""""""""

This set of methods handles the error reporting and manages the error
queue. The error queue works as a stack. New errors are added on top
of the previous ones. When an error is read from the queue it is the
last one in that is taken (last in, first out). An error is actually a
short array comprised of an error number and an error message.

The error queue exists only at run-time. It is not stored into session
or any other form of permanence.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         devLog

   Description
         Writes a message to the devlog, implicitly using the service key as a
         log key. Depends on the member variable “writeDevLog” being set to
         true (it's set to false by default).


.. container:: table-row

   Method
         errorPush

   Description
         Puts a new error on top of the queue stack.


.. container:: table-row

   Method
         errorPull

   Description
         Removes the latest (topmost) error in the queue stack.


.. container:: table-row

   Method
         getLastError

   Description
         Returns the error number from the latest error in the queue, or true
         if queue is empty.


.. container:: table-row

   Method
         getLastErrorMsg

   Description
         Same as above, but returns the error message.


.. container:: table-row

   Method
         getErrorMsgArray

   Description
         Returns an array with the error messages of all errors in the queue.


.. container:: table-row

   Method
         getLastErrorArray

   Description
         Returns the latest error as an array (number and message).


.. container:: table-row

   Method
         resetErrors

   Description
         Empties the error queue.


.. ###### END~OF~TABLE ######


General service functions
"""""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         checkExec

   Description
         This method checks the availability of one or more executables on the
         server. A comma-separated list of excutables names is provided as a
         parameter. The method returns true if  **all** executables are
         available.

         The method relies on :code:`t3lib\_exec::checkCommand()` to find the
         executables, so it will search through the paths defined/allowed by
         the TYPO3 configuration.


.. container:: table-row

   Method
         deactivateService

   Description
         Internal method to temporarily deactivate a service at run-time, if it
         suddenly fails for some reason.


.. ###### END~OF~TABLE ######


I/O tools
"""""""""

A lot of early services were designed to handle files, like those used
by the DAM. Hence the base service class provides a number of methods
to simplify the service developer's life when it comes to read and
write files. In particular it provides an easy way of creating and
cleaning up temporary files.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         checkInputFile

   Description
         Checks if a file exists and is readable within the paths allowed by
         the TYPO3 configuration.


.. container:: table-row

   Method
         readFile

   Description
         Reads the content of a file and returns it as a string. Calls on
         :code:`checkInputFile()` first.


.. container:: table-row

   Method
         writeFile

   Description
         Writes a string to a file, if writable and within allowed paths. If no
         file name is provided, the data is written to a temporary file, as
         created by :code:`tempFile()` below. The file path is returned.


.. container:: table-row

   Method
         tempFile

   Description
         Creates a temporary file and keeps its name in an internal registry of
         temp files.


.. container:: table-row

   Method
         registerTempFile

   Description
         Adds a given file name to the registry of temporary files.


.. container:: table-row

   Method
         unlinkTempFiles

   Description
         Deletes all the registered temporary files.


.. ###### END~OF~TABLE ######


I/O Input and I/O output
""""""""""""""""""""""""

These methods provide a standard way of defining or getting the
content that needs to be processed – if this is the kind of operation
that the service provides – and the processed output after that.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         setInput

   Description
         Sets the content (and optionally the type of content) to be processed.


.. container:: table-row

   Method
         setInputFile

   Description
         Sets the input file from which to get the content (and optionally the
         type).


.. container:: table-row

   Method
         getInput

   Description
         Gets the input to process. If the content is currently empty, tries to
         read it from the input file.


.. container:: table-row

   Method
         getInputFile

   Description
         Gets the name of the input file, after putting it through
         :code:`checkInputFile()` . If no file is defined, but some content is,
         the method writes the content to a temporary file and returns the path
         to that file.


.. container:: table-row

   Method
         setOutputFile

   Description
         Sets the output file name.


.. container:: table-row

   Method
         getOutput

   Description
         Gets the output content. If an output file name is defined, the
         content is gotten from that file.


.. container:: table-row

   Method
         getOutputFile

   Description
         Gets the name of the output file. If such file is not defined, a
         temporary file is created with the output content and that file's path
         is returned.


.. ###### END~OF~TABLE ######


Service implementation
""""""""""""""""""""""

These methods are related to the general functioning of services.
:code:`**init()**`  **and** :code:`**reset()**`  **are the most
important methods to implement when developing your own services.**

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         init

   Description
         This method is expected to perform any necessary initialization for
         the service. Its return value is critical. It should return false if
         the service is not available for whatever reason. Otherwise it should
         return true.

         Note that's it's not necessary to check for OS compatibility, as this
         will already have been done by :code:`t3lib\_extMgm::addService()`
         when the service is registered.

         Executables should be checked, though, if any.

         The init() method is automatically called by
         :code:`t3lib\_div::makeInstanceService()` when requesting a service.


.. container:: table-row

   Method
         reset

   Description
         When a service is requested by a call to
         :code:`t3lib\_div::makeInstanceService()` , the generated instance of
         the service class is kept in a registry (
         :code:`$GLOBALS['T3\_VAR']['makeInstanceService']` ). When the same
         service is requested again during the same code run, a new instance is
         **not** created. Instead the stored instance is returned. At that
         point the :code:`reset()` method is called.

         This method can be used to clean up data that may have been set during
         the previous use of that instance.


.. container:: table-row

   Method
         \_\_destruct

   Description
         Clean up method. The base implementation calls on
         :code:`unlinkTempFiles()` to delete all temporary files.


.. ###### END~OF~TABLE ######

The little schema below summarizes the process of getting a service
instance and when each of :code:`init()` and :code:`reset()` are
called.

