<?php

namespace App\Traits\Models;

trait FormEntryParentEntity {
    public function attachParentEntity($entriesQueryBuilder) {
        $parentEntityType = $this->getTypeAsParentEntity();
        $parentEntityTable = $this->getTable();
        $entriesQueryBuilder
        ->leftJoin(
            $parentEntityTable,
            function($join) use ($entriesQueryBuilder, $parentEntityType, $parentEntityTable) {
                $entriesTable = $entriesQueryBuilder->getModel()->getTable();

                $join->on("$entriesTable.parent_entity_id", '=', "$parentEntityTable.id")
                ->where("$entriesTable.parent_entity_type_id", '=', $parentEntityType->id);
            }
        );
    }

}
