.. include:: ../../../../Includes.txt


.. _AvailableActionsForExtensionEvent:


=================================
AvailableActionsForExtensionEvent
=================================

.. versionadded:: 10.3

Event that is triggered when rendering an additional action (currently within a Fluid ViewHelper) in the Extension Manager.

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
===

 - :Method:
         getPackageKey()
   :Description:
         Returns the package key.
   :ReturnType:
         string


 - :Method:
         getPackageData()
   :Description:
         Returns the meta data of the current extension.
   :ReturnType:
         string

 - :Method:
         getActions()
   :Description:
         Returns the available actions.
   :ReturnType:
         array


 - :Method:
         addAction()
   :Description:
         Add an action to display.
   :Arguments:
      - `actionKey`: Unique key for the action
      - `content`: (HTML) content to display
   :ReturnType:
         void

 - :Method:
         setActions()
   :Description:
         Overwrites the actions array.
   :Arguments:
      - `actions`: Array of actions (key = identifier, value = content)
   :ReturnType:
         void



