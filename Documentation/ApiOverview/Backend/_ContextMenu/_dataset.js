ContextMenuActions.renameFile(table, uid, dataset): void {
  const actionUrl = dataset.actionUrl;
  top.TYPO3.Backend.ContentContainer.setUrl(
    actionUrl + '&target=' + encodeURIComponent(uid)
    + '&returnUrl=' + ContextMenuActions.getReturnUrl()
  );
}
