TYPO3.Modal.confirm('Warning', 'You may break the internet!', TYPO3.Severity.warning, [
  {
    text: 'Break it',
    active: true,
    trigger: function() {
      // break the net
    }
  }, {
    text: 'Abort!',
    trigger: function() {
      TYPO3.Modal.dismiss();
    }
  }
]);
