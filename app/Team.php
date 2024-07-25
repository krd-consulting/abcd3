<?php

namespace App;

use App\Entity;
use App\RecordType;
use App\Traits\Models\Active;

class Team extends Entity
{
    use Active;

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
}
