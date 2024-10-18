..  include:: /Includes.rst.txt

..  index:: system requirements, apache, nginx, database, mysql, sqlite

..  _system-requirements:

===================
System Requirements
===================

TYPO3 requires a web server running PHP and access to a database.

Composer is also required for local development.

If you want TYPO3 to automatically carry out image processing – for example
scaling or cropping – you will need
`GraphicsMagick (version 1.3 or newer) <http://www.graphicsmagick.org>`__ or
`ImageMagick (version 6 or newer) <https://imagemagick.org>`__ installed on
the server. (GraphicsMagick is preferable.)

For up-to-date information about TYPO3's system requirements visit `get.typo3.org
<https://get.typo3.org/version/#system-requirements>`_.

..  include:: PHP.rst.txt

Web Server
==========

..  tabs::

    ..  tab:: Apache

        ..  include:: Apache.rst.txt

    ..  tab:: NGINX

        ..  include:: NGINX.rst.txt

    ..  tab:: IIS

        ..  include:: IIS.rst.txt

Database
========

..  include:: Database.rst.txt

Composer
========

Composer is only required for **local** installations - see
`https://getcomposer.org <https://getcomposer.org>`_ for further information.
It is recommended to always use the latest available Composer version.
TYPO3 v12 LTS requires at least Composer version 2.1.0.
