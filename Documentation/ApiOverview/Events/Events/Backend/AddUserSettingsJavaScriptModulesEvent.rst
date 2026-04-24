..  include:: /Includes.rst.txt
..  index:: Events; AddUserSettingsJavaScriptModulesEvent
..  _AddJavaScriptModulesEvent:
..  _AddUserSettingsJavaScriptModulesEvent:

=====================================
AddUserSettingsJavaScriptModulesEvent
=====================================

..  versionchanged:: 14.3
    This event was moved from :php:`TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent`
    as the system extension `setup` was integrated into :composer:`typo3/cms-backend`.

JavaScript events in custom user settings configuration options should not be
placed as inline JavaScript. Instead, use a dedicated JavaScript module to
handle custom events.

..  _AddUserSettingsJavaScriptModulesEvent-example:

Example
=======

..  literalinclude:: _AddUserSettingsJavaScriptModulesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/UserSettings/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


..  _AddUserSettingsJavaScriptModulesEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/AddUserSettingsJavaScriptModulesEvent.rst.txt

..  _AddUserSettingsJavaScriptModulesEvent-api-13:

Migration from AddJavaScriptModulesEvent to AddUserSettingsJavaScriptModulesEvent
=================================================================================

When dropping TYPO3 v13 support, switch to using the new location of the event:

..  code-block:: diff

    + use TYPO3\CMS\Backend\Event\AddUserSettingsJavaScriptModulesEvent;
      use TYPO3\CMS\Core\Attribute\AsEventListener;
    - use TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent;

      final class SetupModuleListener
      {
          #[AsEventListener('my-extension/setup-module-listener')]
        - public function __invoke(AddJavaScriptModulesEvent $event): void
        + public function __invoke(AddUserSettingsJavaScriptModulesEvent $event): void
          {
              $event->addJavaScriptModule('@my-extension/setupModule/some-file.js');
          }
      }

If you need to support TYPO3 v13 and v14 only listen to the legacy event
:php:`TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent`.

For better dual version compatibility, no deprecation is emitted
when using the legacy event location.
