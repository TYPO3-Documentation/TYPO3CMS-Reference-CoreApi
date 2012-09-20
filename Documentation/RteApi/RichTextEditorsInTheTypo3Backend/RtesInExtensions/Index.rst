

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


RTEs in Extensions
^^^^^^^^^^^^^^^^^^

TYPO3 supports any Rich Text Editor for which someone might write a
connector to the RTE API. This means that you can freely choose
whatever RTE you want to use among those available from the Extension
Repository on typo3.org.

TYPO3 comes with a built-in RTE called "rtehtmlarea", but other RTEs
are available in the TYPO3 Extension Repository.

You can enable more than one RTE if you like but only one will be
active at a time. Since Rich Text Editors often depend on browser
versions, operating systems etc. each RTE must have a method in the
API class which reports back to the system if the RTE is available in
the current environment. The Rich Text Editor available to the backend
user will be the  *first loaded* RTE which reports back to TYPO3 that
it  *is available* in the environment. If the RTE is not available,
the next RTE Extension loaded will be asked.

For example the RTE "rtehtmlarea" is available under Windows and Linux
and under both MSIE and Mozilla. Opposite the "rte" extension is only
available under MSIE / Windows. If the "rtehtmlarea" extension is
loaded before the "rte" extension then the "rtehtmlarea" RTE is always
used. But if "rte" is loaded first then it is also asked for
availability first; the result is that under Windows / MSIE the "rte"
(the "traditional" RTE in TYPO3) is used while "rtehtmlarea" will be
used in other environments.

