<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\PersonFormFactory;
use App\Model\PersonDao;
use Nette\Application\UI\Form;
use Nette\Utils\DateTime;


final class PersonPresenter extends BasePresenter
{
   /** @var PersonDao */
	private PersonDao $personDao;

	/** @var UserFormFactory */
	private PersonFormFactory $personFormfactory;


	public function __construct(PersonDao $personDao, PersonFormfactory $personFormfactory)
	{
		$this->personDao = $personDao;
		$this->personFormfactory = $personFormfactory;
	}

	public function actionEdit(int $personId): void
	{
		$person = $this->personDao->get($personId);

		if ( ! $person) {
			$this->error("Person was not found.");
		}

		$birthday = DateTime::from($person->birthday);

		$this["personForm"]->setDefaults([
			"firstName" => $person->first_name,
			"lastName" => $person->last_name,
			"gender" => $person->gender,
			"birthday" => $birthday->format("d.m.Y"),
			"tel" => $person->tel
		]);
	}
	
	public function createComponentPersonForm(): Form
	{
		$personForm = $this->personFormfactory->create();

		$personForm->onSuccess[] = [$this, "personFormSucceeded"];

		return $personForm;
	}

	public function personFormSucceeded(Form $form, \stdClass $values): void
	{
		$personId = $this->getParameter("personId");

		if ( ! $personId) {
			$this->personDao->add([
				"first_name" => $values->firstName,
				"last_name" => $values->lastName,
				"gender" => $values->gender,
				"birthday" => DateTime::from($values->birthday),
				"tel" => $values->tel
			]);
			
			$this->flashMessage($values->firstName . " " .$values->lastName . " byl úspěšně přidán.", "success");

		} else {
			$this->personDao->update([
				"id" => $personId,
				"first_name" => $values->firstName,
				"last_name" => $values->lastName,
				"gender" => $values->gender,
				"birthday" => DateTime::from($values->birthday),
				"tel" => $values->tel
			]);

			$this->flashMessage($values->firstName . " " .$values->lastName . " byl úspěšně upraven.", "success");
		}

	}
}