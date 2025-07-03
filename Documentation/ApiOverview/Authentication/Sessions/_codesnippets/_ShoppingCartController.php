<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class ShoppingCartController extends ActionController
{
    public const FORM_SESSION = 'myextension_cart';

    public function putItemAction(Item $item): ResponseInterface
    {
        // Fetch cart from session or create a new one
        $cart = $this->getCartFromSession() ?? new Cart();
        $cart->add($item);
        $this->storeCartInSession($cart);
        return $this->redirect('list');
    }

    public function list(): ResponseInterface
    {
        $this->view->assign('cart', $this->getCartFromSession());
        return $this->htmlResponse();
    }

    private function getFrontendUser(): FrontendUserAuthentication
    {
        // This will create an anonymous frontend user if none is logged in
        return $this->request->getAttribute('frontend.user');
    }

    private function storeCartInSession(Cart $cart): void
    {
        // We use type ses to store the data in the session
        $this->getFrontendUser()->setKey('ses', self::FORM_SESSION, serialize($cart));
        // Important: store session data! Or it is not available in the next request!
        $this->getFrontendUser()->storeSessionData();
    }

    private function getCartFromSession(): ?Cart
    {
        $data = $this->getFrontendUser()->getKey('ses', self::FORM_SESSION);
        if (is_string($data)) {
            $cart = unserialize($data);
            if ($cart instanceof Cart) {
                return $cart;
            }
        }
        return null;
    }
}
