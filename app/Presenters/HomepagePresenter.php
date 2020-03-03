<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\PeopleOverview;
use App\Components\PeopleOverviewFactory;

use App\Model\PersonDao;


final class HomepagePresenter extends BasePresenter
{
	/** @var PeopleOverviewFactory */
	private PeopleOverviewFactory $peopleOverviewFactory;

	/** @var PersonDao */
	private PersonDao $personDao;

	public function __construct(PersonDao $personDao, PeopleOverviewFactory $peopleOverviewFactory)
	{
		$this->personDao = $personDao;
		$this->peopleOverviewFactory = $peopleOverviewFactory;
	}

	public function createComponentPeopleOverview(): PeopleOverview
	{
		return $this->peopleOverviewFactory->create($this->personDao->getSelection());
	}
}