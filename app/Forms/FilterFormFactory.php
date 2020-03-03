<?php

declare(strict_types=1);

namespace App\Forms;

use App\Forms\Interfaces\IFormFactory;
use Nette;
use Nette\Application\UI\Form;


/**
 * Factory for people overview filter form.
 */
final class FilterFormFactory implements IFormFactory
{
   use Nette\SmartObject;

   /** @var FormFactory */
	private FormFactory $factory;

   public function __construct(FormFactory $factory)
	{
		$this->factory = $factory;
   }
   
   /**
    * Creates filter form for people overview.
    *
    * @return Form
    */
   public function create(): Form
   {
      $form = $this->factory->create();

      $form->addSelect("gender", "Pohlaví", [
			"Muž" => "Muž",
			"Žena" => "Žena"
      ]);

      $form->addSubmit("filter", "Filtrovat");
      
      return $form;
   }

}