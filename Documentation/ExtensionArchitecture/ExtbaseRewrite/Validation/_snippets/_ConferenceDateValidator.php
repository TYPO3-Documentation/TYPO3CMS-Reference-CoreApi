namespace MyVendor\MyExtension\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class ConferenceDateValidator extends AbstractValidator
{
    protected string $message = 'my_extension:validator.conference.endBeforeStart';

    protected array $translationOptions = ['message'];

    protected $supportedOptions = [
        'message' => [null, 'Custom translation key or message text', 'string'],
    ];

    protected function isValid(mixed $value): void
    {
        if ($value->getEndDate() <= $value->getStartDate()) {
            $this->addErrorForProperty(
                'endDate',
                $this->translateErrorMessage($this->message),
                1716299001,
            );
        }
    }
}