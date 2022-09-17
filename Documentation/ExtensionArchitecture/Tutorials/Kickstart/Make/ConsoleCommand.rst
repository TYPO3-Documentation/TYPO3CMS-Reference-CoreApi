
Create a new console command
----------------------------

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 make:command

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev exec vendor/bin/typo3 make:command

    ..  group-tab:: Legacy

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 make:command

You will be prompted with a list of installed extensions. If your newly created
extension is missing, check if you installed it properly.

When prompted choose a name and path for the command.

`Should the command be schedulable? (yes/no) [no]:`
    If you want the command to be available in the backend in module
    :guilabel:`System > Scheduler` choose `yes`. If it should be only callable
    from the console, for example if it prompts for input, choose `no`.

The following files will be created or changed:

..  code-block:: none
    :caption: Page tree of directory :file:`src/extensions`

    $ tree src/extensions
    └── my-test
        ├── Classes
        |   └── Command (*)
        |   |   └── MyCommand.php (*)
        ├── Configuration
        |   └── Services.yaml (*)
        ├── composer.json
        └── ext_emconf.php

After a new console command was created you have to delete the cache for it to
be available:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 cache:flush

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev exec cache:flush

    ..  group-tab:: Legacy

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 cache:flush

Then you can call it form command line:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 my-test:my

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev exec my-test:my

    ..  group-tab:: Legacy

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 my-test:my

Read more about how you can fill your
:ref:`console command <symfony-console-commands>` with life.

