.. include:: ../../../../Includes.txt


.. _AvailableActionsForExtensionEvent:


=================================
AvailableActionsForExtensionEvent
=================================

.. versionadded:: 10.3

Event that is triggered when rendering an additional action (currently within a Fluid ViewHelper) in the Extension Manager.::

   public function getActions(): array
   {
       return $this->actions;
   }

   public function addAction(string $actionKey, string $content): void
   {
       $this->actions[$actionKey] = $content;
   }

   public function setActions(array $actions): void
   {
       $this->actions = $actions;
   }


API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getPackageKey()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getPackageData()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getActions()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

addAction()
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|` :aspect:`Arguments:` `$actionKey`: Unique key for the action; `$content`: (HTML) content to display

   Add an action to display.

setActions()
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|` :aspect:`Arguments:` `$ctions`: Array of actions (key = identifier, value = content)

   |nbsp|
