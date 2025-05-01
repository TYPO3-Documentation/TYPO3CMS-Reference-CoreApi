<?php
declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Tea;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Country\CountryProvider;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TeaSupplyController extends ActionController {
    // ...

    public function __construct(
        private readonly CountryProvider $countryProvider,
        private readonly TeaRepository $teaRepository,
    ) {}

    public function showCountryFormAction(Tea $tea): ResponseInterface
    {
        // Do something in PHP, using the Country API
        if ($tea->getCountryOfOrigin()->getAlpha2IsoCode() == 'DE') {
            // ...
        }
        $this->view->assign('tea', $tea);

        // You can access the `CountryProvider` API for additional country-related
        // operations, too (ideally use Dependency Injection for this):
        $this->view->assign('countries', $this->countryProvider->getAll());

        return $this->htmlResponse();
    }
    public function changeCountryOfOriginAction(Tea $tea): ResponseInterface
    {
        $this->teaRepository->update($tea);
        $this->addFlashMessage('Country of origin was changed');
        return $this->redirect('showCountryForm');
    }
}
