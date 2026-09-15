<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

class ItemsProcFunc
{
  /**
  * Modifies the select box of orderBy-options.
  *
  * @param array &$config configuration array
  */
  public function user_orderBy(array &$config)
  {
    // simple and stupid example
    // change this to dynamically populate the list!
    $config['items'] = [
      // label, value
      ['Timestamp', 'timestamp'],
      ['Title', 'title'],
    ];
  }

  // ...
}
