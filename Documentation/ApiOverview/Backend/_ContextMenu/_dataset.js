ContextMenuActions.renameFile(table, uid, dataset)
{
  const actionUrl = dataset.actionUrl;
  top.TYPO3.Backend.ContentContainer.setUrl(
    actionUrl + '&target=' + encodeURIComponent(uid) + '&returnUrl='
    + ContextMenuActions.getReturnUrl()
  );
}
