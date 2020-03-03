<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Utils\DateTime;

/**
 * Validates inputed birthday.
 */
class BirthdayValidator
{
   use Nette\SmartObject;
   
   /**
    * validates if the birthday does not exceed 100 years.
    *
    * @param DateTime $birthday
    * @return boolean
    */
   public function validate(DateTime $birthday): bool
   {
      $now = DateTime::from(time());

      return $birthday < $now->modify("-100 years") ? false : true;
   }
}