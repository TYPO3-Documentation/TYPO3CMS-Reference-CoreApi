

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


Using t3lib\_TCEmain in scripts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

It's really easy to use the class "t3lib\_TCEmain" in your own
scripts. All you need to do is include the class, build a $data/$cmd
array you want to pass to the class and call a few methods.

However please mind that these scripts have to be run in the
**backend scope** ! There must be a global $BE\_USER object.

In your script you simply insert this line to include the class:

::

   require_once (PATH_t3lib . 'class.t3lib_tcemain.php');

When that is done you can create an instance of t3lib\_TCEmain. Here
follows a few code listings with comments which will provide you with
enough knowledge to get started. It is assumed that you have populated
the $data and $cmd arrays correctly prior to these chunks of code. The
syntax for these two arrays is explained on the previous pages.


((generated))
"""""""""""""

Example: Submitting data
~~~~~~~~~~~~~~~~~~~~~~~~

This is the most basic example of how to submit data into the
database. It is four lines. Line 1 instantiates the class, line 2
defines that values will be provided without escaped characters
(recommended!), line 3 registers the $data array inside the class and
initializes the class internally! Finally line 4 will execute the data
submission.

::

      1: $tce = t3lib_div::makeInstance('t3lib_TCEmain');
      2: $tce->stripslashes_values = 0;
      3: $tce->start($data, array());
      4: $tce->process_datamap();


Example: Executing commands
~~~~~~~~~~~~~~~~~~~~~~~~~~~

The most basic way of executing commands. Line 1 creates the object,
line 2 defines that values will be provided without escaped characters
(recommended), line 3 registers the $cmd array inside the class and
initializes the class internally! Finally line 4 will execute the
commands.

::

      1: $tce = t3lib_div::makeInstance('t3lib_TCEmain');
      2: $tce->stripslashes_values=0;
      3: $tce->start(array(), $cmd);
      4: $tce->process_cmdmap();


Example: Clearing cache
~~~~~~~~~~~~~~~~~~~~~~~

In this example the clear-cache API is used. No data is submitted, no
commands executed. Still you will have to initialize the class by
calling the start() method (which will initialize internal variables).

Notice: Clearing "all" cache will be possible only for users that are
"admin" or for users with specific permissions to do so.

::

      1: $tce = t3lib_div::makeInstance('t3lib_TCEmain');
      2: $tce->start(array(), array());
      3: $tce->clear_cacheCmd('all');


Example: Complex data submission
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Imagine the $data array something like this:

::

   $data = array(
       'pages' => array(
           'NEW_1' => array(
               'pid' => 456,
               'title' => 'Title for page 1',
           ),
           'NEW_2' => array(
               'pid' => 456,
               'title' => 'Title for page 2',
           ),
       )
   );

This aims to create two new pages in the page with uid "456". In the
follow code this is submitted to the database. Notice how line 3
reverses the order of the array. This is done because otherwise "page
1" is created first, then "page 2" in the  *same* PID meaning that
"page 2" will end up above "page 1" in the order. Reversing the array
will create "page 2" first and then "page 1" so the "expected order"
is preserved.

Apart from this line 6 will send a "signal" that the page tree should
be updated at the earliest occasion possible. Finally, the cache for
all pages is cleared in line 7.

::

      1: $tce = t3lib_div::makeInstance('t3lib_TCEmain');
      2: $tce->stripslashes_values = 0;
      3: $tce->reverseOrder = 1;
      4: $tce->start($data, array());
      5: $tce->process_datamap();
      6: t3lib_BEfunc::getSetUpdateSignal('updatePageTree');
      7: $tce->clear_cacheCmd('pages');


Example: Both data and commands executed with alternative user object
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In this case it is shown how you can use the same object instance to
submit both data and execute commands if you like. The order will
depend on the order of line 4 and 5.

In line 3 the start() method is called, but this time with the third
possible argument which is an alternative BE\_USER object. This allows
you to force another backend user account to create stuff in the
database. This may be useful in certain special cases. Normally you
should not set this argument since you want TCE to use the global
$BE\_USER.

::

      1: $tce = t3lib_div::makeInstance('t3lib_TCEmain');
      2: $tce->stripslashes_values = 0;
      3: $tce->start($data, $cmd, $alternative_BE_USER);
      4: $tce->process_datamap();
      5: $tce->process_cmdmap();

