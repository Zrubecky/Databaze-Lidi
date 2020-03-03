<?php

declare(strict_types=1);

namespace App\Forms;

use App\Forms\Interfaces\IFormFactory;
use Nette;
use Nette\Application\UI\Form;


/**
 * Simple form factory which returns Nette Form object.
 */
final class FormFactory implements IFormFactory
{
	use Nette\SmartObject;

	/**
	 * Returns new Form.
	 *
	 * @return Form
	 */
	public function create(): Form
	{
		return new Form;
	}
}
