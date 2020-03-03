<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Interfaces\IPersonDao;
use Nette;
use Nette\Database\Context;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;


/**
 * DAO class which handles person database manipulation.
 */
class PersonDao implements IPersonDao
{
   use Nette\SmartObject;

   /** @var Context */
   private Context $database;

   private const PERSON_TABLE = "people";

   public function __construct(Context $database)
   {
      $this->database = $database;
   }

   /**
    * Returns person table selection object of all records.
    *
    * @return Selection
    */
   public function getSelection(): Selection
   {
      return $this->database->table(self::PERSON_TABLE);
   }

   /**
    * Returns Person active row for individual person.
    *
    * @param integer $id person id.
    * @return ActiveRow|null
    */
   public function get(int $id): ?ActiveRow
   {
      return $this->getSelection()->get($id);
   }

   /**
    * Adds person to the database and returns person Active Row object.
    *
    * @param iterable $personValues
    * @return ActiveRow|null
    */
   public function add(iterable $personValues): ?ActiveRow
   {
      $person = $this->getSelection()->insert($personValues);

      return $person ?: null;
   }

   /**
    * Removes the person out of the database.
    *
    * @param integer $id
    * @return integer count of changed rows.
    */
   public function remove(int $id): int
   {
      return $this->getSelection()->where("id", $id)->delete();
   }

   /**
    * Updates the user data in the database.
    *
    * @param iterable $personValues
    * @return integer count of changed rows.
    */
   public function update(iterable $personValues): int
   {
      return $this->getSelection()->where("id", $personValues["id"])->update($personValues);
   }
}