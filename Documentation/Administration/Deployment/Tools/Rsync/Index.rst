:navigation-title: Rsync

..  include:: /Includes.rst.txt
..  _deployment-rsync:

=========================
Rsync deployment of TYPO3
=========================

`rsync <https://rsync.samba.org/>`_ is a command-line tool for copying files
between systems.

It can be used to deploy both
`Composer-based <https://docs.typo3.org/permalink/t3coreapi:installation>`_
and `classic TYPO3 installations <https://docs.typo3.org/permalink/t3coreapi:classic-installation>`_
by synchronizing project files from a local environment (such as a
`DDEV setup <https://docs.typo3.org/permalink/t3start:installation-ddev-tutorial>`_)
to a production server over
`SSH <https://www.digitalocean.com/community/tutorials/what-is-ssh>`_.

rsync is often used for small to medium-sized projects, or by teams who prefer
a controlled and scriptable way to deploy TYPO3 without setting up full
:abbr:`CI/CD (Continuous Integration / Continuous Deployment)` systems. It can
also be part of automated workflows in larger or more complex environments.

By default, rsync only transfers changed files, compared to uploading zip or tar archives,
and avoids the need to unpack anything on the server.

Tools like
`Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_
or `TYPO3 Surf <https://docs.typo3.org/other/typo3/surf/main/en-us/Index.html>`_
often use rsync internally to transfer files, but add features such as
automated deployment steps, release management, and rollback support on top.

Using rsync directly gives you full control over what is transferred and when,
but you are responsible for handling additional deployment tasks yourself.

..  contents:: Table of contents

..  seealso::

    -   `rsync homepage <https://rsync.samba.org/>`_
    -   `Beginner tutorial (Linuxize) <https://linuxize.com/post/how-to-use-rsync-for-local-and-remote-data-transfer-and-synchronization/>`_
    -   `rsync manual <https://linux.die.net/man/1/rsync>`_

..  _deployment-rsync-deployment:

Initial Rsync deployment
========================

Let us assume you have a local TYPO3 installation running in DDEV. You have
already created some content, uploaded some images, etc.

On initial deployment you want to transfer all the files that
are needed by your installation, including user-managed content like images.

Assuming:

*   Your local project is in `~/Projects/typo3-site/`
*   Your remote server is `user@example.org`
*   The target directory on the server is /var/www/typo3-site/

..  code-block:: bash
    :caption: Run the command from your local development environment

    rsync -avz --progress \
      --exclude='.git/' \
      --exclude='.ddev/' \
      --exclude='node_modules/' \
      ~/Projects/typo3-site/ \
      user@example.org:/var/www/typo3-site/

To use a custom SSH identity file or port, see:
:ref:`deployment-rsync-sync-ssh`.

In addition, transfer the database dump to a temporary location:

..  code-block:: bash
    :caption: Run the command from your local development environment

    rsync -avz --progress \
      ~/Projects/typo3-site/dump.sql \
      user@example.org:/tmp/

Additional steps are required beyond file transfer. See also
`Initial deployment <https://docs.typo3.org/permalink/t3coreapi:manual-deployment-initial>`_.

..  _deployment-rsync-deployment-regular:

Regular Deployments with rsync
==============================

On subsequent deployments you only have to deploy the files that contain the
code that you have developed locally. You do not want to override images that
your editors have uploaded in the backend.

..  code-block:: bash
    :caption: Run the command from your local development environment

    rsync -avz --progress \
      --exclude='.git/' \
      --exclude='.ddev/' \
      --exclude='node_modules/' \
      --exclude='public/fileadmin/' \
      --exclude='public/uploads/' \
      ~/Projects/typo3-site/ \
      user@example.org:/var/www/typo3-site/

To use a custom SSH identity file or port, see:
:ref:`deployment-rsync-sync-ssh`.

There are additional steps needed beyond file transfer. See also
`Regular deployment <https://docs.typo3.org/permalink/t3coreapi:manual-deployment-regular>`_.

As the steps of a regular deployment have to be repeated many times during the
lifetime of a TYPO3 project, it is helpful to bundle the instructions into a recipe
and let `Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_
do the work for you.

..  _deployment-rsync-sync-fileadmin:

Syncing fileadmin from production to local
==========================================

In addition to deploying files to the server, you may also want to transfer
editor-generated content such as images and documents back into your local
development environment. This is useful, for example, when debugging issues
with specific media files or previewing content changes made on production.

To sync the `fileadmin/` folder from the production server to your local
TYPO3 setup:

Assuming:

*   Your production server is `user@example.org`
*   The project is located at `/var/www/typo3-site/` on the server
*   Your local development environment is at `~/Projects/typo3-site/`

..  code-block:: bash
    :caption: Run the command from your local development environment

    rsync -avz --progress \
      user@example.org:/var/www/typo3-site/public/fileadmin/ \
      ~/Projects/typo3-site/public/fileadmin/

This command will only copy changed files and will preserve the directory structure.
It does not delete local files unless you explicitly add the `--delete` flag.

To preview changes before syncing, you can use `--dry-run`:

..  code-block:: bash
    :caption: Run the command from your local development environment

    rsync -avz --progress --dry-run \
      user@example.org:/var/www/typo3-site/public/fileadmin/ \
      ~/Projects/typo3-site/public/fileadmin/

To use a custom SSH identity file or port, see:
:ref:`deployment-rsync-sync-ssh`.

..  _deployment-rsync-sync-ssh:

Additional SSH configuration
============================

If your server uses a custom SSH port or requires a specific private key,
you can specify them with the `-e` flag:

..  code-block:: bash
    :caption: Run the command from your local development environment

    rsync -avz --progress \
      -e "ssh -i ~/.ssh/id_rsa -p 2222" \
      user@example.org:/var/www/typo3-site/ \
      ~/Projects/typo3-site/

Replace `~/.ssh/id_rsa` with your SSH key path and `2222` with the
actual SSH port if different from the default (22).
