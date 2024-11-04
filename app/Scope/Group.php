<?php

namespace App\Scope;

use App\Scope as ScopeTable;
use App\Collection as CollectionTable;

class Group extends Scope {
    public function getCollectionType() {
        return CollectionTable::where('name', 'Group')->first();
    }
}