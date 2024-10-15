..  include:: /Includes.rst.txt

..  index::
    Request attribute; Nonce
..  _typo3-request-attribute-nonce:

=====
Nonce
=====

The :php:`nonce` request attribute is related to :ref:`content-security-policy`.

..  seealso::
    https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/nonce

It is always available in backend context and only in frontend context, if the
according :ref:`feature <typo3ConfVars_sys_features_security.frontend.enforceContentSecurityPolicy>`
is enabled.

One can retrieve the nonce like this:

..  code-block:: php

    // use TYPO3\CMS\Core\Domain\ConsumableString

    /** @var ConsumableString|null $nonce */
    $nonceAttribute = $this->request->getAttribute('nonce');
    if ($nonceAttribute instanceof ConsumableString) {
        $nonce = $nonceAttribute->consume();
    }
