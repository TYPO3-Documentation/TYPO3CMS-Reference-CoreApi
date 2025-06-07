:navigation-title: Reverse Proxy

..  include:: /Includes.rst.txt
..  _reverse-proxy-container:

==========================================================
Reverse proxies in container-based production environments
==========================================================

..  include:: /Administration/Docker/Production/_Experimental.rst.txt

Container-based production environments frequently require reverse proxy
configurations for TYPO3 to run properly.

..  seealso::

    *   `Running TYPO3 behind a reverse proxy or load balancer <https://docs.typo3.org/permalink/t3coreapi:reverse-proxy-setup>`_

Containerized environments typically involve a **dynamic or wide range of IP addresses**,
making it impractical to rely on a single IP for reverse proxy configuration.

Refer to the documentation of the hosting company or to their support hotline
to find out the concrete ranges.

You can use the CIDR notation, for example `10.0.0.0/8` or a wildcard. If the
hosting provider can promise no range at all you can use wildcard `*`, be sure
this is safe for the hosting environment being used.

..  note::
    Always test your configuration in a staging environment before deploying to
    production to avoid disruptions.

..  _reverse-proxy-container-image:

Configure the reverse proxy settings in your custom Docker image
================================================================

If you maintain the :file:`config/system/additional.php` within your
project-specific docker image, you can use
`Application Context <https://docs.typo3.org/permalink/t3coreapi:application-context>`_
or environment variables to activate the reverse proxy settings on production
only. For example:

..  literalinclude:: /Administration/Production/ReverseProxy/_codesnippets/_additional.php
    :caption: config/system/additional.php

..  _reverse-proxy-container-volume:

Configure the reverse proxy in a mounted volume
===============================================

If you have mounted :file:`config/system/settings.php` or a path above to a
persistent volume on the host you can edit this file directly.

Incorrect reverse proxy settings can unfortunately render the TYPO3 backend and Install Tool inaccessible
(See `Bug #106797 Missing reverse Proxy leads to perpetual loading Install tool login <https://forge.typo3.org/issues/106797>`_).

Therefore you need to edit the :file:`config/system/settings.php` or add a
:file:`config/system/additional.php` for the reverse proxy settings.

If your host supports this you can use SSH or SFTP to edit the file.

If your host does not support SSH directly into the container you can run a
container that allows you to edit files like
`filebrowser/filebrowser <https://hub.docker.com/r/filebrowser/filebrowser>`_
or run a one-time container job to adjust the settings like
`linawolf/typo3-nexaa-reverse-proxy-copier <https://hub.docker.com/repository/docker/linawolf/typo3-nexaa-reverse-proxy-copier/general>`_
to override the :file:`config/system/additional.php`. This container is
designed to copy reverse proxy settings into a live system and should be
used with caution.
