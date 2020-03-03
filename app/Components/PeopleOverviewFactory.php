<?php

declare(strict_types=1);

namespace App\Components;

use App\Forms\FilterFormFactory;
use App\Model\GenderValidator;
use App\Model\PersonDao;
use App\Model\SortOrderValidator;
use Nette;
use Nette\Database\Table\Selection;

/**
 * Factory class for peopleOverview.
 */
final class PeopleOverviewFactory
{
   use Nette\SmartObject;
   
   /** @var PersonDao */
   private PersonDao $personDao;

	/** @var OverviewPaginatorFactory */
	private OverviewPaginatorFactory $overviewPaginatorFactory;

	/** @var FilterFormFactory */
   private FilterFormFactory $filterFormFactory;

   /** @var GenderValidator */
	private GenderValidator $genderValidator;

	/** @var SortOrderValidator */
	private SortOrderValidator $sortOrderValidator;
   

   public function __construct(PersonDao $personDao, OverviewPaginatorFactory $overviewPaginatorFactory, FilterFormFactory $filterFormFactory, GenderValidator $genderValidator, SortOrderValidator $sortOrderValidator)
	{
      $this->personDao = $personDao;
		$this->filterFormFactory = $filterFormFactory;
      $this->overviewPaginatorFactory = $overviewPaginatorFactory;
      $this->genderValidator = $genderValidator;
		$this->sortOrderValidator = $sortOrderValidator;
   }
   
   /**
    * Creates PeopleOverview compnent.
    *
    * @param Selection $people
    * @return PeopleOverview
    */
   public function create(Selection $people): PeopleOverview
   {
      return new PeopleOverview($this->personDao, $this->overviewPaginatorFactory, $this->filterFormFactory, $people, $this->genderValidator, $this->sortOrderValidator);
   }
}