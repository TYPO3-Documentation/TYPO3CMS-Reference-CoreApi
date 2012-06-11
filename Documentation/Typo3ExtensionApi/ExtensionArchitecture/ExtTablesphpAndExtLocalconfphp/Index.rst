

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


ext\_tables.php and ext\_localconf.php
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

These two files are the most important for the execution of extensions
to TYPO3. They contain configuration used within the system on almost
every request. Therefore they should be optimized for speed.

- ext\_localconf.php is always included in global scope of the script,
  either frontend or backend.You  *can* put functions and classes into
  the script, but you should consider doing that in other ways because
  such classes and functions would  *always* be available - and it would
  be better if they were included only when needed.So stick to change
  values in TYPO3\_CONF\_VARS only!

- ext\_tables.php is  *not* always included in global scope on the other
  hand (in the frontend)Don't put functions and classes - or include
  other files which does - into this script!

- Use the API of the class extMgm for various manipulative tasks such as
  adding tables, merging information into arrays etc.

- Before the inclusion of any of the two files, the variables $\_EXTKEY
  is set to the extention-key name of the module and $\_EXTCONF is set
  to the configuration from $TYPO3\_CONF\_VARS["EXT”]["extConf"][
  *extension key* ]

- $TYPO3\_LOADED\_EXT[ *extension key* ] contains information about
  whether the module is loaded as  *local, global* or  *system* type,
  including the proper paths you might use, absolute and relative.

- The inclusion can happen in two ways:

- Either the files are included individually on each request (many file
  includes) ($TYPO3\_CONF\_VARS["EXT”]["extCache"]=0;)

- or (better) the files are automatically imploded into one single
  temporary file (cached) in typo3conf/ directory (only one file
  include) ($TYPO3\_CONF\_VARS["EXT"]["extCache"]=1; [or 2]). This is
  default (value “1”)

In effect this means:

- Your ext\_tables.php / ext\_localconf.php file must be designed so
  that it can safely be read and subsequently imploded into one single
  file with all the other configuration scripts!

- You must NEVER use a “return” statement in the files global scope -
  that would make the cached script concept break.

- You should NOT rely on the PHP constant \_\_FILE\_\_ for detection of
  include path of the script - the configuration might be executed from
  a cached script and therefore such information should be derived from
  the $TYPO3\_LOADED\_EXT[ *extension key* ] array. E.g.
  $TYPO3\_LOADED\_EXT[$\_EXTKEY]["siteRelPath"]

