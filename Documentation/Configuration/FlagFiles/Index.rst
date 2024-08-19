.. include:: /Includes.rst.txt

.. _flag-files:

==========
Flag files
==========

TYPO3 uses a set of special files known as flag files or indicator files to
control and manage low-level configurations, behaviors, and security settings
of the system. These files act as triggers that enable or disable specific
features or functionalities in TYPO3, often without requiring direct
modifications to the core configuration files.

Flag files are typically placed in specific locations within the TYPO3 file
system and are usually named in a way that reflects their purpose.

Below is a list of commonly used TYPO3 flag files, along with explanations of
their functions and typical use cases.

..  confval-menu::
    :display: table
    :Location:
    :Legacy Location:

    ..  confval:: LOCK_BACKEND
        :name: flag-file-lock-backend
        :Content: empty or arbitrary text file
        :Location: typo3conf/LOCK_BACKEND
        :Legacy Location: typo3conf/LOCK_BACKEND
        :TYPO3 Commands: `vendor/bin/typo3 backend:lock`, `vendor/bin/typo3 backend:unlock`

        If the file is set an error message is displayed when you try to log into
        the backend:

        ..  warning::
            Backend access by browser is locked for maintenance. Remove lock by
            removing the file "typo3conf/LOCK_BACKEND" or use CLI-scripts.

        ..  code-block:: bash
            :caption: Console commands to lock/unlock the backend

            # Lock the TYPO3 Backend for everyone including administrators
            vendor/bin/typo3 backend:lock

            # Unlock the TYPO3 Backend after it has been locked
            vendor/bin/typo3 backend:unlock

        This file locks access to the TYPO3 backend. When present, it prevents
        users from logging into the backend, often used during maintenance or
        for security reasons.

        **Use Case**: Temporarily restrict backend access to prevent unauthorized
        changes or when performing critical updates.


    ..  confval:: FIRST_INSTALL
        :name: flag-file-first-install
        :Content: empty or arbitrary text file
        :Location: public/FIRST_INSTALL
        :Legacy Location: FIRST_INSTALL

        This file initiates the TYPO3 installation process. If the file exists,
        TYPO3 directs the user to the installation wizard.

        **Use Case**: Automatically initiate the installation process on a
        fresh TYPO3 setup.

        See also: :ref:`Installing TYPO3 <t3start:install>`.

        If you are working with the :composer:`helhum/typo3-console` there is
        also a console command available to do the first installation:

        :ref:`install:setup <helhum/typo3-console:typo3_console-command-reference-install-setup>`

    ..  confval:: ENABLE_INSTALL_TOOL
        :name: flag-file-enable-install-tool
        :Content: empty or "KEEP_FILE"
        :Location: config/ENABLE_INSTALL_TOOL
        :Legacy Location: typo3conf/ENABLE_INSTALL_TOOL
        :TYPO3 Commands: None

        ..  versionchanged:: 12.2
            The location of this file has been changed for Composer-based
            installations from :path:`typo3conf/ENABLE_INSTALL_TOOL` to
            :path:`config/ENABLE_INSTALL_TOOL` or
            :path:`var/transient/ENABLE_INSTALL_TOOL`

        When this file is set, it allows access to the TYPO3 Install Tool.
        See also :ref:`The ENABLE_INSTALL_TOOL file <security-install-tool-access-enable-file>`.

        ..  include:: /_includes/_EnableInstallTool.rst.txt
            :show-buttons:

        ..  include:: /_includes/_EnableInstallToolWarning.rst.txt
            :show-buttons:

        This file unlocks the Install Tool, allowing access for configuration
        and maintenance tasks.

        **Use Case**: Temporarily enable the Install Tool for performing system
        configurations or updates, then remove the file to re-secure the tool.

        If you are working with the :composer:`helhum/typo3-console` there are
        also console commands available to enable or disable the install tool:

        *   :ref:`install:lock <helhum/typo3-console:typo3_console-command-reference-install-lock>`
        *   :ref:`install:unlock <helhum/typo3-console:typo3_console-command-reference-install-unlock>`
