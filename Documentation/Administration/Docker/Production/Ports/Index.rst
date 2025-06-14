:navigation-title: Ports

..  include:: /Includes.rst.txt
.. _container-hosting-ports:

===================================================
Ports when running TYPO3 on container-based hosting
===================================================

..  include:: /Administration/Docker/Production/_Experimental.rst.txt

When deploying TYPO3 to a container-based hosting platform, make sure that the
container's **internal port 80** is correctly exposed to the outside.

Most platforms handle this by routing incoming traffic to a fixed external
port (for example, port 443 for HTTPS) and forwarding it to port 80 inside the
container. You do **not** need to modify the TYPO3 image or change its
internal port.

Make sure your hosting configuration (such as ingress or service mapping)
forwards traffic to port `80` inside the container.

..  tip::

    The TYPO3 container listens on port 80 — this is a convention. If your
    host platform expects a different internal port, you must configure
    port mapping accordingly.

..  _classic-docker-reverse-proxy:

Using HTTPS and reverse proxies
===============================

If you are accessing TYPO3 via `https://` but the container receives
traffic on internal port `80`, TYPO3 may detect the request as `http://`
and generate a site configuration with the wrong scheme.

This can lead to redirect loops or broken links in the frontend.

To fix this, you should use a **reverse proxy** (such as Traefik or nginx)
that handles HTTPS and forwards the original request information to TYPO3.

..  seealso::
    For details, see: :ref:`reverse-proxy-container`

After installation, **check your site configuration** in TYPO3. If it was
automatically created with a `http://` base URL but you're accessing the site
via `https://`, you must adjust the base URL manually in the backend:
:guilabel:`Site Management > Sites`.
