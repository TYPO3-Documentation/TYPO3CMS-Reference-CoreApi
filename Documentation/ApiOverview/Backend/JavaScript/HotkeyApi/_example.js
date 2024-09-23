import Hotkeys, {ModifierKeys} from '@typo3/backend/hotkeys.js';

Hotkeys.register([Hotkeys.normalizedCtrlModifierKey, ModifierKeys.SHIFT, 'e'], keyboardEvent => {
  console.log('Triggered on Ctrl/Cmd+Shift+E');
}, {
  scope: 'my-extension/module',
  bindElement: document.querySelector('.some-element')
});

// Get the currently active scope
const currentScope = Hotkeys.getScope();

// Make use of registered scope
Hotkeys.setScope('my-extension/module');
