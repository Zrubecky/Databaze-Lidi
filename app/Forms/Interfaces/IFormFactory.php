<?php

declare(strict_types=1);

namespace App\Forms\Interfaces;

use Nette\Application\UI\Form;


interface IFormFactory
{
   public function create(): Form;
}