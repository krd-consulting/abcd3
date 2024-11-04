<?php

namespace App;

use App\Contracts\FormReference;
use App\Contracts\FormFieldReference;
use App\Contracts\FormEntryParentEntity;
use App\Collection as CollectionTable;
use App\Entity;
use App\RecordType;
use App\Traits\Models\Active;
use App\Traits\Models\FormReference as FormReferenceTrait;
use App\Traits\Models\FormEntryParentEntity as FormEntryParentEntityTrait;

class Team extends Entity implements FormReference, FormFieldReference, FormEntryParentEntity
{
    use Active, FormReferenceTrait, FormEntryParentEntityTrait;

    protected $searchColumns = [
        'name',
    ];

    public function records()
    {
        return $this->belongsToMany('App\Record');
    }

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function groups()
    {
        return $this->hasManyThrough('App\Group', 'App\Program');
    }

    public function getAvailableRecordTypesAttribute()
    {
        return $this->records->load('record_type')->pluck('record_type')->unique();
    }

    public function getPathAttribute()
    {
        return "/$this->table/$this->id";
    }

    public function scopeAvailableFor($query, $user) {
        $scope = $user->scope;

        switch($scope) {
            case 'universal':
                return $query;

            default:
                return $query->whereIn('teams.id', $user->teams->pluck('id'));
        }
    }

    public function associateRecord(Record $record)
    {
      $this->records()->attach($record);

      return $record;
    }

    public function attachFormFieldReference($formEntryQueryBuilder, $formTable, $fieldColumn, $targetId) {
        $formEntryQueryBuilder
            ->leftJoin('teams', "teams.id", '=', "$formTable.$fieldColumn")
            ->addSelect('teams.name as field_1_reference_value')
            ->addSelect('NULL as field_1_reference_secondary_value')
            ->addSelect(DB::Raw("CONCAT('/groups/', groups.id) as $fieldColumn".'_reference_path'));
        
        return [
            'groups.name as field_1_reference_value',
            'NULL as field_1_reference_secondary_value',
            DB::Raw("CONCAT('/teams/', teams.id) as $fieldColumn".'_reference_path')
        ];
    }

    public function getFormFieldReferenceValues($targetId, $keywords) {
        return $this
            ->search($keywords)
            ->addSelect('teams.name as label')
            ->addSelect('teams.id as value');
    }

    public function getTypeAsParentEntity() {
        return CollectionTable::where('name', 'Team')->first();
    }
}
