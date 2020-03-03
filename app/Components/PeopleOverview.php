<?php

declare(strict_types=1);

namespace App\Components;

use App\Forms\FilterFormFactory;
use App\Model\GenderValidator;
use App\Model\PersonDao;
use App\Model\SortOrderValidator;
use Nette;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Database\Table\Selection;
use Nette\Utils\Paginator;


/**
 * PeopleOverview component handles displaying people.
 */
final class PeopleOverview extends Control
{
	use Nette\SmartObject;

   /** @var PersonDao */
   private PersonDao $personDao;

	/** @var OverviewPaginatorFactory */
	private OverviewPaginatorFactory $overviewPaginatorFactory;

	/** @var FilterFormFactory */
	private FilterFormFactory $filterFormFactory;

	/** @var Selection */
	private Selection $people;

	/** @var GenderValidator */
	private GenderValidator $genderValidator;

	/** @var SortOrderValidator */
	private SortOrderValidator $sortOrderValidator;

	/** @var Paginator */
   private Paginator $paginator;
	
	/** @var string */
   private const COMPONENT_NAME = "peopleOverview";

	/** @persistent int */
	public int $page = 1;

	/** @persistent string */
	public string $sortOrder = "ASC";

	/** @persistent ?string */
	public ?string $filterGender = null;

	public function __construct(PersonDao $personDao, OverviewPaginatorFactory $overviewPaginatorFactory, FilterFormFactory $filterFormFactory, Selection $people, GenderValidator $genderValidator, SortOrderValidator $sortOrderValidator)
	{
      $this->personDao = $personDao;
		$this->filterFormFactory = $filterFormFactory;
      $this->overviewPaginatorFactory = $overviewPaginatorFactory;
		$this->people = $people;
		$this->genderValidator = $genderValidator;
		$this->sortOrderValidator = $sortOrderValidator;
	}

	/**
	 * Creates the component via componenty factory.
	 * Adds onSuccess callback to filter gender function.
	 *
	 * @return Form
	 */
	public function createComponentFilterForm(): Form
	{
		$form = $this->filterFormFactory->create();

		$form->onSuccess[] = function(Form $form, \stdClass $values) {
			$this->handleFilterGender($values->gender);
		};

		return $form;
	}

	/**
	 * Toggles people sort order.
	 *
	 * @return void
	 */
	public function handleSortPeople(): void
	{
		$this->sortOrder = ($this->sortOrder === "ASC" ? "DESC" : "ASC");

		if ($this->presenter->isAjax()) {
			$this->redrawControl(self::COMPONENT_NAME);
		}
	}

	/**
	 * Sets gender to be filtered.
	 *
	 * @param string $gender
	 * @return void
	 */
	public function handleFilterGender(string $gender): void
	{
		$this->filterGender = $gender;

		if ($this->presenter->isAjax()) {
			$this->redrawControl(self::COMPONENT_NAME);
		}
	}

	/**
	 * Resets the filter gender variable.
	 *
	 * @return void
	 */
	public function handleRemoveFilter(): void
	{
		$this->filterGender = null;
		
		if ($this->presenter->isAjax()) {
			$this->redrawControl(self::COMPONENT_NAME);
		}
	}

	/**
	 * Removes the person out of the database.
	 *
	 * @param integer $id
	 * @return void
	 */
	public function handleRemovePerson(int $id): void
	{
		$this->personDao->remove($id);
		$this->flashMessage("Člověk byl odebrán.", "success");

		if ($this->presenter->isAjax()) {
			$this->redrawControl(self::COMPONENT_NAME);
		}
   }
	
	/**
	 * Changes page in pagination.
	 *
	 * @param integer $page
	 * @return void
	 */
   public function handleChangePage(int $page): void
   {
      $this->page = $page;

      if ($this->presenter->isAjax()) {
			$this->redrawControl(self::COMPONENT_NAME);
		}
   }

	/**
	 * Renders whole component.
	 *
	 * @return void
	 */
	public function render(): void
	{	
		$sortOrder = $this->sortOrder;

		if ($this->filterGender) {
			if ($this->genderValidator->validate($this->filterGender)) {
				$this->people->where("gender", $this->filterGender);
			} else {
				$this->error("Parametr filtrace není validní.");
			}
		}

		if ($this->sortOrder) {
			if ($this->sortOrderValidator->validate($sortOrder)) {
				$this->people->order("created_at $sortOrder");
			} else {
				$this->error("Parametr řazení není validní.");
			}
		}

		$this->paginator = $this->overviewPaginatorFactory->create($this->page, count($this->people));
		$peopleToDisplay = $this->people->limit($this->paginator->getLength(), $this->paginator->getOffset());
	
		$this->template->order = $sortOrder;
		$this->template->people = $peopleToDisplay;
		$this->template->paginator = $this->paginator;

		if (count($this->people) === 0) {
			$this->flashMessage("Žádní lidé k dispozici.");
		}   
		
      $this->template->render(__DIR__ . '/Templates/peopleOverview.latte'); 
	}
}