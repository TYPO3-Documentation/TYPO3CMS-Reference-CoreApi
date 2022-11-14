ContextMenuActions.renameFile(table, uid)
{
  const actionUrl = $(this).data('action-url');
  top.TYPO3.Backend.ContentContainer.setUrl(
    actionUrl + '&target=' + encodeURIComponent(uid) + '&returnUrl='
    + ContextMenuActions.getReturnUrl()
  );
}
