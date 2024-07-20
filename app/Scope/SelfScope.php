<?php

namespace App\Scope;

use App\Scope as ScopeTable;
use App\Collection as CollectionTable;

class SelfScope extends Scope {
    public function getCollectionType() {
        return CollectionTable::where('name', 'Self')->first();
    }
}