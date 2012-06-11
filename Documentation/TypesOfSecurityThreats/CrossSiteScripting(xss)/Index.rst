

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


Cross Site Scripting (XSS)
^^^^^^^^^^^^^^^^^^^^^^^^^^

Cross-site scripting occurs when data that is being processed by an
application is not filtered for any suspicious content. It is most
common with forms on websites where a user enters data which is then
processed by the application. When the data is stored or sent back to
the browser in an unfiltered way, malicious code may be executed. A
typical example is a comment form for a blog or guest book. When the
submitted data is simply stored in the database, it will be sent back
to the browser of visitors if they view the blog or guest book
entries. This could be as simple as the inclusion of additional text
or images, but it could also contain JavaScript code of iframes that
load code from a 3rd party website.

