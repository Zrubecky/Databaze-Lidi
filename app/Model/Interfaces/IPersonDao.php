<?php

declare(strict_types=1);

namespace App\Model\Interfaces;

use Nette\Database\Context;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;


interface IPersonDao
{
   public function __construct(Context $database);

   public function getSelection(): Selection;

   public function get(int $id): ?ActiveRow;

   public function add(iterable $personValues): ?ActiveRow;

   public function remove(int $id): int;

   public function update(iterable $personValues): int;

}