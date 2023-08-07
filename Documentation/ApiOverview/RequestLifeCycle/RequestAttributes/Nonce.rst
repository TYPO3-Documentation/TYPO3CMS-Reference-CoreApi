..  include:: /Includes.rst.txt

..  index::
    Request attribute; Nonce
..  _typo3-request-attribute-nonce:

=====
Nonce
=====

..  versionadded:: 12.4

The :php:`nonce` request attribute is related to :ref:`content-security-policy`.

..  seealso::
    https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/nonce

It is available in backend and frontend context, if the according feature is
enabled:

*   :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.backend.enforceContentSecurityPolicy'] <typo3ConfVars_sys_features_security.backend.enforceContentSecurityPolicy>`
*   :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.enforceContentSecurityPolicy'] <typo3ConfVars_sys_features_security.frontend.enforceContentSecurityPolicy>`

One can retrieve the nonce like this:

..  code-block:: php

    // use TYPO3\CMS\Core\Domain\ConsumableString

    /** @var ConsumableString|null $nonce */
    $nonceAttribute = $this->request->getAttribute('nonce');
    if ($nonceAttribute instanceof ConsumableString) {
        $nonce = $nonceAttribute->consume();
    }
