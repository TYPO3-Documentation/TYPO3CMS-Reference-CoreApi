..  include:: /Includes.rst.txt
..  index:: Message Bus
..  _message-bus:

===========
Message bus
===========

TYPO3 provides a message bus solution based on `symfony/messenger`_. It has the
ability to send messages and then handle them immediately (synchronous) or
send them through transports (asynchronous, for example, queues) to be handled
later.

For backwards compatibility, the default implementation uses the synchronous
transport. This means that the message bus will behave exactly as before, but it
will be possible to switch to a different (asynchronous) transport on a
per-project base.

To offer asynchronicity, TYPO3 also provides a transport implementation based on
the `Doctrine DBAL messenger transport`_ from Symfony and a basic implementation
of a consumer command.

..  seealso::
    To familiarize yourself with the concept, please also read the following
    resources:

    *   `The Symfony Messenger Component`_
    *   `Sync & Queued Message Handling`_

    More details and an example implementation are described in this blog post:

    *   `Message Bus and Message Queue in TYPO3`_


..  contents:: Table of Contents
    :local:


..  _message-bus-everyday-usage:

"Everyday" usage - as a developer
=================================

..  _message-bus-dispatch:

Dispatch a message
------------------

..  rst-class:: bignums

#.  Add a PHP class for your message object (which is an arbitrary PHP class)

    ..  literalinclude:: _DemoMessage.php
        :caption: EXT:my_extension/Classes/Queue/Message/DemoMessage.php

#.  Inject the :php:`MessageBusInterface` into your class and call the
    :php:`dispatch()` method

    ..  literalinclude:: _MyClass.php
        :caption: EXT:my_extension/Classes/MyClass.php

..  _message-bus-handler:

Register a handler
------------------

Implement the handler class

..  literalinclude:: _DemoHandler.php
    :caption: EXT:my_extension/Classes/Queue/Handler/DemoHandler.php

The message handler can be registered using the symfony PHP attribute
:php:`\Symfony\Component\Messenger\Attribute\AsMessageHandler`.

A :file:`Services.yaml` entry is needed to use :yaml:`before`/:yaml:`after`
for registration if you need to define an order:

..  literalinclude:: _demo-handler.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

..  _message-bus-routing:

"Everyday" usage - as a system administrator/integrator
=======================================================

By default, TYPO3 will behave like in versions before TYPO3 v12. This means that
the message bus will use the synchronous transport and all messages will be
handled immediately. To benefit from the message bus, it is recommended to
switch to an asynchronous transport. Using asynchronous transports increases the
resilience of the system by decoupling external dependencies even further.

Currently, the TYPO3 Core provides an asynchronous transport based on the
`Doctrine DBAL messenger transport`_. This transport is configured to use the
default TYPO3 database connection. It is pre-configured and can be used by
changing the settings:

..  code-block:: php
    :caption: config/settings.php | config.additional.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing']['*'] = 'doctrine';

This will route all messages to the asynchronous transport (mind the :php:`*`).

..  attention::
    If you are using the Doctrine transport, make sure to take care of running
    the :ref:`consume command <message-bus-consume-command>`.

..  seealso::
    :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing'] <typo3confvars-sys-messenger-routing>`


..  _message-bus-consume-command:

Async message handling - the consume command
--------------------------------------------

To consume messages, run the command:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 messenger:consume <receiver-name>

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 messenger:consume <receiver-name>

By default, you should run:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 messenger:consume doctrine

    ..  group-tab:: Classic mode installation (No Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 messenger:consume doctrine

The command takes almost all options of the Symfony command of the same name.

..  versionchanged:: 14.2
    :changelog: feature-106261-1762614000

    The worker options below were added. Before, the command stopped after one
    hour on its own and reported that through an `--exit-code-on-limit`
    option. Both are gone: a worker now runs until you give it a limit.

A worker does not stop on its own. In continuous operation, configure a limit
so that the PHP process is periodically recycled to release memory:

`--time-limit`, `-t`
    Stop after this number of seconds.

`--limit`, `-l`
    Stop after this number of messages.

`--failure-limit`, `-f`
    Stop after this number of failed messages.

`--memory-limit`, `-m`
    Stop when the worker uses more than this much memory, for example `128M`.

A limit only takes effect after the current message is handled, so the worker
never stops in the middle of one. These options select what the worker reads
and how it waits:

`--all`
    Consume from every configured receiver.

`--bus`, `-b`
    Dispatch the received messages to this bus. Without it, TYPO3 picks the
    bus itself.

`--queues`
    Consume only from these queues of the receiver. Repeat the option per
    queue.

`--sleep`
    Wait this number of seconds before asking for messages again when none
    were found. The default is `1`.

`--keepalive`
    Keep the connection of the transport alive, if the transport implements
    it. The default interval is 5 seconds.

Whichever limit is reached, the worker process exits with code `0`. Run it
under a service manager like `systemd`_ that keeps the service active and
automatically restarts a fresh worker process.

The following code provides an example for a service. Create the following
file on your server:

..  code-block:: ini
    :caption: /etc/systemd/system/typo3-message-consumer.service

    [Unit]
    Description=Run the TYPO3 message consumer
    Requires=mariadb.service
    After=mariadb.service

    [Service]
    Type=simple
    User=www-data
    Group=www-data
    ExecStart=/usr/bin/php8.5 /var/www/myproject/vendor/bin/typo3 messenger:consume doctrine --time-limit=3600
    # The command exits with 0 on its time limit, so restart it either way
    Restart=always
    RestartSec=1

    [Install]
    WantedBy=multi-user.target

Where no service manager is available, the command can run as a
:ref:`scheduler task <symfony-console-commands-scheduler>` instead.

..  important::

    The `messenger:consume` command blocks subsequent scheduler tasks from
    executing while it is running. Set `--time-limit` to a value lower than the
    scheduler's cron interval (for example, 240 seconds for a 5-minute cron
    interval) so that the task completes before the next run.


..  _message-bus-advanced-usage:

Advanced usage
==============

..  _message-bus-custom-transport:

Configure a custom transport (senders/receivers)
------------------------------------------------

Transports are configured in the services configuration. To allow the
configuration of a transport per message, the TYPO3 configuration
(:file:`settings.php`, :file:`additional.php` on system level, or
:file:`ext_localconf.php` in an extension) is utilized. The transport/sender
name used in the settings is resolved to a service that has been tagged with
:yaml:`message.sender` and the respective identifier.

..  literalinclude:: _CustomTransport.php
    :caption: config/settings.php | config/additional.php | EXT:my_extension/ext_localconf.php

..  literalinclude:: _custom-transport.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml | config/system/services.yaml

The TYPO3 Core has been tested with three transports:

*   :php:`\Symfony\Component\Messenger\Transport\Sync\SyncTransport`
    (default)
*   :php:`\Symfony\Component\Messenger\Bridge\Doctrine\Transport\DoctrineTransport`
    (using the Doctrine DBAL messenger transport)
*   :php:`\Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport`
    (for testing)

..  _message-bus-add-rate-limiter:

Add rate limiter
----------------

Rate limiting can be applied to asynchronous messages processed through the
consume command. This allows controlling message processing rates to:

*   Stay within external service limits (API quotas, mail sending thresholds)
*   Manage server resource utilization

..  _message-bus-example-rate-limiter:

Example: usage of a rate limiter
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Use the following configuration to limit the process of messages to
max. 100 each 60 seconds:

..  literalinclude:: _add-rate-limiter.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml | config/system/services.yaml

..  hint::
    As TYPO3 default transport for asynchronous messages is `doctrine` you also
    have to set the tags `identifier` to `doctrine`.

..  _message-bus-in-memory-transport-testing:

`InMemoryTransport` for testing
-------------------------------

The :php:`InMemoryTransport` is a transport that should only be used while
testing.

..  literalinclude:: _in-memory-transport.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml | config/system/services.yaml


..  _message-bus-configure-middleware:

Configure a custom middleware
-----------------------------

The middleware is set up in the services configuration. By default, the
:php:`\Symfony\Component\Messenger\Middleware\SendMessageMiddleware` and the
:php:`\Symfony\Component\Messenger\Middleware\HandleMessageMiddleware` are
registered. See also the `Custom middleware`_ section in the Symfony
documentation.

To add your own middleware, tag it as :yaml:`messenger.middleware` and set the
order using TYPO3's :yaml:`before` and :yaml:`after` ordering mechanism:

..  literalinclude:: _custom-middleware.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml | config/system/services.yaml


..  _Custom middleware: https://symfony.com/doc/current/components/messenger.html#bus
..  _Doctrine DBAL messenger transport: https://github.com/symfony/doctrine-messenger
..  _Message Bus and Message Queue in TYPO3: https://usetypo3.com/messages-in-typo3.html
..  _Sync & Queued Message Handling: https://symfony.com/doc/current/messenger.html
..  _symfony/messenger: https://symfony.com/doc/current/components/messenger.html
..  _systemd: https://en.wikipedia.org/wiki/Systemd
..  _The Symfony Messenger Component: https://symfony.com/doc/current/components/messenger.html
