.. include:: Images.txt

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


Introduction
^^^^^^^^^^^^

The following pages present some examples of how you can use the APIs
of core libraries. Remember, ultimately the source is the
documentation and the only point here is to show examples. Whenever
you would like to use core features that are not shown here you should
search in the core and system extensions for implementations that can
work as an example for you.


Debugging with debug()
""""""""""""""""""""""

A very common tool used by TYPO3 developers is the debug() function.
It basically prints out the content of a variable in a nicely
formatted table. There are extensions available which extends the view
from the debug() function to something more fancy. Here I will just
present the basic version.

Use the debug() function whenever you want to look "inside" an array
or parameters passed to a user processing function. Usually it makes
it very easy to understand the parameters. For instance, lets say you
call a script with the GET parameter string
"?id=123&test[key]=A&test[key2]=B". How will the GET vars look to your
application inside? Well, using the debug function makes that easy:

::

   debug(t3lib_div::_GET(),'GET variables:');

The output in the browser will look like:

|img-21| Notice that the debug() function is a wrapper for
t3lib\_div::debug() and the difference is that debug() (defined in
"t3lib/config\_default.php") will only output information if your IP
address is within a certain range typical for internal networks.

