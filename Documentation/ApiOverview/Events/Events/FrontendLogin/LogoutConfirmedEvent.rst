..  include:: /Includes.rst.txt
..  index:: Events; LogoutConfirmedEvent
..  _LogoutConfirmedEvent:


====================
LogoutConfirmedEvent
====================

The PSR-14 event :php:`\TYPO3\CMS\FrontendLogin\Event\LogoutConfirmedEvent` is
triggered when a logout was successful.

Example: Delete stored private key from disk on logout
======================================================

Upon logout a private key the user uploaded for decryption of private
information should be deleted at once. There is only a logout event if the user
actively clicks the logout button, so if the user would just close the browser
window there would be no :php:`LogoutConfirmedEvent`. For this case we need
a second line of defense like a scheduler task (out of scope of this example).

The currently logged-in user derived from the :php:`\TYPO3\CMS\Core\Context\Context`
is now an anonymous user that is not logged in. The information on which user
just logged out cannot be determined from the context or the methods from the
event. We therefore need different logic to determine the user who just logged
out. This logic is not part of the example bellow.

..  literalinclude:: _LogoutConfirmedEvent/_DeletePrivateKeyOnLogout.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListeners/DeletePrivateKeyOnLogout.php

To support both TYPO3 v13 and v12.4 register the event listener in the
:file:`Services.yaml`:

..  literalinclude:: _LogoutConfirmedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/LogoutConfirmedEvent.rst.txt
