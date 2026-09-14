<?php

namespace MyVendor\MyExtension\Consumer;

use TYPO3\CMS\Core\Utility\SomeUtility;

class SomeClass
{
  public function someMethod()
  {
    // "Strong" match: Full class combination and method call matches
    \TYPO3\CMS\Core\Utility\SomeUtility::someMethod();

    // "Strong" match: Full class combination and method call matches
    \TYPO3\CMS\Core\Utility\SomeUtility::someMethod('foo');

    // "Strong" match: Use statements are resolved
    SomeUtility::someMethod('foo');

    // "Weak" match: Scanner does not know if $foo is class
    // "SomeUtility", but the method name matches
    $foo = '\TYPO3\CMS\Core\Utility\SomeOtherUtility';
    $foo::someMethod();

    // No match: The method is static but called dynamically
    $foo->someMethod();

    // No match: The method is called with too many arguments
    SomeUtility::someMethod('foo', 'bar');

    // No match: A different method is called
    SomeUtility::someOtherMethod();
  }
}
