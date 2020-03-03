<?php

declare(strict_types=1);

namespace App\Forms;

use App\Forms\Interfaces\IFormFactory;
use App\Model\BirthdayValidator;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\DateTime;


/**
 * Individual Person Form factory class.
 */
final class PersonFormFactory implements IFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private FormFactory $factory;

	/** @var BirthdayValidator */
	private BirthdayValidator $birthdayValidator;

	public function __construct(FormFactory $factory, BirthdayValidator $birthdayValidator)
	{
		$this->factory = $factory;
		$this->birthdayValidator = $birthdayValidator;
	}

	/**
	 * Returns individual person form.
	 *
	 * @return Form
	 */
	public function create(): Form
	{
      $form = $this->factory->create();
      
		$form->addText("firstName", "Jméno:")
			->setRequired("Prosím, vyplňte jméno")
			->addRule(Form::MIN_LENGTH, "Jméno musí obsahovat alespoň %d znaky", 3)
			->setAttribute("placeholder", "Jméno");

		$form->addText("lastName", "Příjmení:")
		->setRequired("Prosím, vyplňte příjmení")
		->addRule(Form::MIN_LENGTH, "Příjmení musí obsahovat alespoň %d znaky", 2)
		->setAttribute("placeholder", "Příjmení");

		$form->addSelect("gender", "Pohlaví", [
			"Muž" => "Muž",
			"Žena" => "Žena"
		]);

		$form->addText("birthday", "Datum narození:")
		->setRequired("Prosím vyplňte datum narození")
		->setAttribute("placeholder", "Datum narození (dd.mm.yyyy)")
		->addRule(Form::PATTERN, "Datum Narození musí mít validní formát dd.mm.yyyy", "^([0-2][0-9]|(3)[0-1])(\.)(((0)[0-9])|((1)[0-2]))(\.)\d{4}$");

		$form->addText("tel", "Tel:")
		->setRequired("Prosím, vyplňte telefoní číslo.")
		->setAttribute("placeholder", "Tel.")
		->addRule(Form::PATTERN, "Telefonní číslo musí mít validní formát.", "^[+]?[()/0-9. -]{9,}$");

		$form->addSubmit("submit", "Přidat nového člověka");

		$form->onValidate[] = [$this, "validatePersonForm"];

		return $form;
	}

	/**
	 * Validates person form.
	 * Adds error when form is not valid.
	 *
	 * @param Form $form
	 * @return void
	 */
	public function validatePersonForm(Form $form, \stdClass $values): void
	{
		if ( ! $this->birthdayValidator->validate(DateTime::from($values->birthday))) {
			$form->addError("Datum narození není validní.");
		}
	}
}