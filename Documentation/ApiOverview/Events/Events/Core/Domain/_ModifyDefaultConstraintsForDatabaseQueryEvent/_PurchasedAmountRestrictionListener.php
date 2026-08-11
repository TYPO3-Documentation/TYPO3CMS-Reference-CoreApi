<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Domain\Event\ModifyDefaultConstraintsForDatabaseQueryEvent;

#[AsEventListener(
    identifier: 'my-extension/purchased-amount-restriction',
)]
final readonly class PurchasedAmountRestrictionListener
{
    public function __invoke(ModifyDefaultConstraintsForDatabaseQueryEvent $event): void
    {
        $table = $event->getTable();
        $enableColumns = $GLOBALS['TCA'][$table]['ctrl']['enablecolumns']['purchasedamount'] ?? null;
        if ($enableColumns === null) {
            return;
        }

        [$fromField, $toField] = explode(',', $enableColumns);
        // strictly typed as float, so it is safe to use directly below
        // without a bound query parameter
        $purchasedAmount = $this->getCurrentCustomerPurchasedAmount();

        $expressionBuilder = $event->getExpressionBuilder();
        $event->setConstraints(array_merge(
            $event->getConstraints(),
            [
                'purchasedamount' => $expressionBuilder->and(
                    $expressionBuilder->lte($table . '.' . $fromField, $purchasedAmount),
                    $expressionBuilder->gte($table . '.' . $toField, $purchasedAmount),
                ),
            ],
        ));
    }

    private function getCurrentCustomerPurchasedAmount(): float
    {
        // Your own business logic to determine the value to filter by,
        // for example reading it from the current frontend user session.
        return 0.0;
    }
}
