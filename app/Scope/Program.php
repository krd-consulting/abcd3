<?php

namespace App\Scope;

use App\Scope as ScopeTable;
use App\Collection as CollectionTable;

class Program extends Scope {
    public function getCollectionType() {
        return CollectionTable::where('name', 'Program')->first();
    }
}