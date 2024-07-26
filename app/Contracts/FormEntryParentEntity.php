<?php
namespace App\Contracts;

interface FormEntryParentEntity
{
    public function getTypeAsParentEntity();
    public function attachParentEntity($entriesQueryBuilder);
}
