.. include:: ../../Includes.txt


Two reasons to use services
^^^^^^^^^^^^^^^^^^^^^^^^^^^


1. Freedom of implementation
""""""""""""""""""""""""""""

A service may be implemented multiple times to take into account
different environments like operating systems (Unix, Windows, Mac),
available PHP extensions or other third-party dependencies (other
programming languages, binaries, etc.).

Imagine an extension which could rely on a Perl script for very good
results. Another implementation could exist, that relies only on PHP,
but gives results of lesser quality. With a service you could switch
automatically between the two implementations just by testing the
availability or not of Perl on the server.


2. Extend functionality with extensions
"""""""""""""""""""""""""""""""""""""""

Services are able to handle subtypes. Take the service of the type
"fileMeta" which extracts meta data from files. It provides
information depending on the file type for which it is implemented. ::

   if (is_object($serviceObj = t3lib_div::makeInstanceService('fileMeta', $fileExtension))) {
     $meta = serviceObj->getFileMeta($filename);
   }

Here you can define a common API that doesn't vary whatever the type
of file you are trying to read, greatly simplifying the implementation
of code relying on such services. Any extension can add new subtypes
handling, say 'mp3' for example, and this subtype will automatically
be available to code that uses the "fileMeta" service.

