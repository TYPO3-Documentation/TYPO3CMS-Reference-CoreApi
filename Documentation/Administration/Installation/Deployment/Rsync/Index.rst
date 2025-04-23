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
and `classic TYPO3 installations <https://docs.typo3.org/permalink/t3coreapi:legacyinstallation>`_
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
or `TYPO3 Surf <https://docs.typo3.org/permalink/t3coreapi:deployment-typo3-surf>`_
often use rsync internally to transfer files, but add features such as
automated deployment steps, release management, and rollback support on top.

Using rsync directly gives you full control over what is transferred and when,
but you are responsible for handling additional deployment tasks yourself.

..  seealso::

    -   `rsync homepage <https://rsync.samba.org/>`_
    -   `Beginner tutorial (Linuxize) <https://linuxize.com/post/how-to-use-rsync-for-local-and-remote-data-transfer-and-synchronization/>`_
    -   `rsync manual <https://linux.die.net/man/1/rsync>`_

..  todo:: Add "how-to instructions" for Composer-based and classic installations.
