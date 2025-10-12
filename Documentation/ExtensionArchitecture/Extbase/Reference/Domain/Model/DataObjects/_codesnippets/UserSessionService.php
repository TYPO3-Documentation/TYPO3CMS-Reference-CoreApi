<?php

declare(strict_types=1);

namespace T3docs\BmiCalculator\Service;

use T3docs\BmiCalculator\Domain\Model\Dto\MeasurementsDto;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class UserSessionService
{
    public const SESSION_KEY = 'tx_bmi_calculator_session';
    public function storeIntoSession(RequestInterface $request, MeasurementsDto $measurementsDto): void
    {
        $user = $this->getFrontendUser($request);
        // We use type ses to store the data in the session
        $user->setKey(
            'ses',
            self::SESSION_KEY,
            $measurementsDto->serialize(),
        );
        // Important: store session data! Or it is not available in the next request!
        $this->getFrontendUser($request)->storeSessionData();
    }

    public function getFromSession(RequestInterface $request): ?MeasurementsDto
    {
        $user = $this->getFrontendUser($request);
        $data = $user->getKey('ses', self::SESSION_KEY);
        if (!is_string($data)) {
            return null;
        }
        return MeasurementsDto::deserialize($data);
    }

    private function getFrontendUser(RequestInterface $request): FrontendUserAuthentication
    {
        // This will create an anonymous frontend user if none is logged in
        return $request->getAttribute('frontend.user');
    }
}
