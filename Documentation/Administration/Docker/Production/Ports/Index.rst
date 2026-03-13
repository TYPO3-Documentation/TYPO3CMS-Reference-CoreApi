:navigation-title: Ports

..  include:: /Includes.rst.txt
..  _container-hosting-ports:

===================================================
Ports when running TYPO3 on container-based hosting
===================================================

..  include:: /Administration/Docker/Production/_Experimental.rst.txt

This section applies to running TYPO3 in managed container environments such as
Kubernetes clusters, Nexaa, AWS App Runner, or Azure App Services. These platforms
often map internal container ports (like `80`) to external ports dynamically
(such as `8081` or higher), which may require additional configuration in
TYPO3 and the reverse proxy.

When deploying TYPO3 to a container-based hosting platform, make sure that the
container's **internal port 80** is correctly exposed to the outside.

Most platforms handle this by routing incoming traffic to a fixed external
port (for example, port 443 for HTTPS) and forwarding it to port 80 inside the
container. You do **not** need to modify the TYPO3 image or change its
internal port.

Make sure your hosting configuration (such as ingress or service mapping)
forwards traffic to port `80` inside the container.

..  tip::

    TYPO3 Docker images typically expose port 80 internally. External access is managed
    through your platform’s service or ingress configuration.

..  _classic-docker-reverse-proxy:

Using HTTPS and reverse proxies (SSL Offloading)
================================================

..  seealso::

    **Background reading:**

    `What is SSL Offloading? <https://certera.com/blog/know-what-is-ssl-offloading-and-how-it-works/>`_

When deploying TYPO3 behind a **reverse proxy** (such as Traefik or nginx) that
handles HTTPS termination, it is common for the proxy to **offload SSL**—
meaning the secure connection (HTTPS) is terminated at the proxy, and the
request is forwarded to the container over plain HTTP (port `80`). This
practice is called **SSL offloading**.

However, TYPO3 may detect the incoming request as `http://` (because it is
forwarded as HTTP), and consequently generate site URLs with the wrong scheme.
This can cause redirect loops or incorrect links in the frontend.

TYPO3 typically includes support for reverse proxy setups. When configured
correctly, it will still generate `https://` links even if SSL is offloaded.
Be sure to **enable reverse proxy support in TYPO3** so that it correctly
interprets the original request scheme.

For details, see: :ref:`reverse-proxy-container`

After installation, **check your site configuration** in TYPO3. If it was
automatically created with a `http://` base URL but you're accessing the site
via `https://`, you must adjust the base URL manually in the backend:
:guilabel:`Sites > Setup`.
