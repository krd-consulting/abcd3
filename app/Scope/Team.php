<?php

namespace App\Scope;

use App\Scope as ScopeTable;
use App\Collection as CollectionTable;

class Team extends Scope {
    public function getCollectionType() {
        return CollectionTable::where('name', 'Team')->first();
    }
}