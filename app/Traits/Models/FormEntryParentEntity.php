<?php

namespace App\Traits\Models;

trait FormEntryParentEntity {
    public function attachParentEntity($entriesQueryBuilder) {
        $parentEntityType = $this->getTypeAsParentEntity();
        $parentEntityTable = $this->getTable();
        // Giving joined table an alias so it doesn't conflict
        // if table is joined as a Form Field Entry reference.
        $alias = "{$parentEntityTable}_as_parent_entity_table";
        $entriesQueryBuilder
        ->leftJoin(
            "$parentEntityTable as $alias",
            function($join) use ($entriesQueryBuilder, $parentEntityType, $parentEntityTable, $alias) {
                $entriesTable = $entriesQueryBuilder->getModel()->getTable();

                $join->on("$entriesTable.parent_entity_id", '=', "$alias.id")
                ->where("$entriesTable.parent_entity_type_id", '=', $parentEntityType->id);
            }
        );
    }

}
