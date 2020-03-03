<?php

declare(strict_types=1);

namespace App\Model;

use Nette;

/**
 * Validates inputed birthday.
 */
class SortOrderValidator
{
   use Nette\SmartObject;
   
   /**
    * validates if the sortOrder has a valid value.
    *
    * @param string $sortOrder
    * @return boolean
    */
   public function validate(string $sortOrder): bool
   {
      return $sortOrder === "DESC" or $sortOrder === "ASC" ? true : false;
   }
}