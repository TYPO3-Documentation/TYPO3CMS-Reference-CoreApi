namespace MyVendor\MyExtension\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class SeatCountValidator extends AbstractValidator
{
    protected string $message = 'my_extension:validator.conference.notEnoughSeats';

    protected array $translationOptions = ['message'];

    protected $supportedOptions = [
        'minimum' => [1, 'Minimum number of available seats required', 'integer'],
        'message' => [null, 'Custom translation key or message text', 'string'],
    ];

    protected function isValid(mixed $value): void
    {
        $minimum = $this->options['minimum'];
        if ($value->getAvailableSeats() < $minimum) {
            $this->addError(
                $this->translateErrorMessage($this->message, '', [$minimum]),
                1716300001,
                [$minimum],
            );
        }
    }
}