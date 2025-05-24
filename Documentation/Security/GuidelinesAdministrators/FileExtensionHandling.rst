..  include:: /Includes.rst.txt
..  index:: pair: Security guidelines; File extensions
..  _security-file-extension-handling:

=======================
File extension handling
=======================

Most web servers have a default configuration
mapping file extensions like `.html` or `.txt`
to corresponding mime-types like `text/html` or `text/plain`.
The focus in this section is on handling multiple extensions like `.html.txt` -
in general the last extension part (`.txt` in `.html.txt`) defines the mime-type:

*   `file.html` shall use mime-type `text/html`
*   `file.html.txt` shall use mime-type `text/plain`
*   `file.html.wrong` shall use mime-type `text/plain` (but especially not `text/html`)

Apache's `mod_mime`_ documentation explains their handling of files having multiple extensions.
Directive `TypesConfig` and using a `mime.types`_ map probably
leads to unexpected handling of extension `.html.wrong` as mime-type `text/html`:

..  code-block:: apacheconf

    AddType text/html     html htm
    AddType image/svg+xml svg svgz

Global settings like shown in the example above
are matching `.html` and `.html.wrong` file extension
and have to be limited with `<FilesMatch>`:

..  code-block:: apacheconf

    <FilesMatch ".+\.html?$">
        AddType text/html     .html .htm
    </FilesMatch>
    <FilesMatch ".+\.svgz?$">
        AddType image/svg+xml .svg .svgz
    </FilesMatch>

In case these settings cannot be applied to the global server configuration,
but only to :file:`.htaccess` it is recommended to remove the default behavior:

..  code-block:: apacheconf
    :caption: .htaccess

    RemoveType .html .htm
    RemoveType .svg .svgz

The scenario is similar when it comes to evaluate PHP files -
it is totally expected and fine for files like `test.php` (ending with `.php`) -
but it is definitively unexpected for files like `test.php.html`
(having `.php` somewhere in between).

The expected `default configuration`_ should look like the following
(adjusted to the actual PHP script dispatching via CGI, FPM or any other type):

..  code-block:: apacheconf
    :caption: .htaccess

    <FilesMatch ".+\.php$">
        SetHandler application/x-httpd-php
    </FilesMatch>

..  _mod_mime: https://httpd.apache.org/docs/2.4/mod/mod_mime.html#multipleext
..  _mime.types: https://github.com/apache/httpd/blob/5f32ea94af5f1e7ea68d6fca58f0ac2478cc18c5/docs/conf/mime.types#L1688
..  _default configuration: https://salsa.debian.org/php-team/php/-/blob/dc253886b5b2e9bc8d9e36db787abb083a667fd8/debian/php-cgi.conf#L5-7
