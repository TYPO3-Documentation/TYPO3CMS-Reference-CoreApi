ContextMenuActions.renameFile(table, uid): void {
  const actionUrl = $(this).data('action-url');
  top.TYPO3.Backend.ContentContainer.setUrl(
    actionUrl + '&target=' + encodeURIComponent(uid) + '&returnUrl='
    + ContextMenuActions.getReturnUrl()
  );
}
