<?php

declare(strict_types=1);

namespace App\Components;

use Nette;
use Nette\Utils\Paginator;


/**
 * Factory class which creates overview paginator object.
 */
class OverviewPaginatorFactory
{
   use Nette\SmartObject;
   
   /**
    * Function returns Paginator object.
    *
    * @param integer $page
    * @param integer|null $peopleCount
    * @param integer $peoplePerPage
    * @return Paginator
    */
   public function create(int $page, ?int $peopleCount, int $peoplePerPage = 5): Paginator
   {
      $paginator = new Paginator;
      $paginator->setItemCount($peopleCount);
      $paginator->setItemsPerPage($peoplePerPage);
      $paginator->setPage($page);

      return $paginator;
   }
}