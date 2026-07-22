<?php

declare(strict_types=1);

namespace T3docs\BmiCalculator\Controller;

use Psr\Http\Message\ResponseInterface;
use T3docs\BmiCalculator\Domain\Model\Dto\MeasurementsDto;
use T3docs\BmiCalculator\Service\BmiCalculatorService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CalculatorController extends ActionController
{
    public function __construct(
        private readonly BmiCalculatorService $bmiCalculatorService,
    ) {}

    public function formAction(): ResponseInterface
    {
        $defaultValues = new MeasurementsDto(1.73, 73);
        $this->view->assign('defaultValues', $defaultValues);
        return $this->htmlResponse();
    }
    public function resultAction(MeasurementsDto $measurements): ResponseInterface
    {
        $this->view->assign('measurements', $measurements);
        $this->view->assign(
            'result',
            $this->bmiCalculatorService->calculate($measurements),
        );
        return $this->htmlResponse();
    }
}
