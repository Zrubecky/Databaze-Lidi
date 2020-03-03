<?php

declare(strict_types=1);

namespace App\Model;

use Nette;

/**
 * Validates inputed birthday.
 */
class GenderValidator
{
   use Nette\SmartObject;
   
   /**
    * validates if the gender has a valid value.
    *
    * @param string $gender
    * @return boolean
    */
   public function validate(string $gender): bool
   {
      return $gender === "Muž" or $gender === "Žena" ? true : false;
   }
}