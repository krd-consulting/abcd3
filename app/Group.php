<?php

namespace App;

use App\Record;
use App\User;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

use App\Contracts\FormReference;
use App\Traits\Models\FormReference as FormReferenceTrait;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Entity implements FormReference
{
    use FormReferenceTrait;

    protected $appends = ['path'];

    public $searchColumns = ['name', 'description'];

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function records()
    {
        return $this->belongsToMany('App\Record')
            ->withTimestamps();
    }

    public function addRecord(Record $record)
    {
        $record->assignGroup($this);
    }

    public function getPathAttribute()
    {
        return "/$this->table/$this->id";
    }

    public function scopeAvailableFor($query, User $user) {
        $scope = $user->scope;

        switch($scope) {
            case 'universal':
                return $query;

            case 'team':
                return $query->inTeams($user);

            case 'program':
                return $query->inPrograms($user);

            default:
                return $query->inCaseload($user);
        }
    }

    public function scopeInTeams($query, User $user)
    {
        $programs = $user->teamPrograms->pluck('id');

        return $query->whereIn('program_id', $programs);
    }

    public function scopeInPrograms($query, User $user)
    {
        $programs = $user->programs->pluck('id');

        return $query->whereIn('program_id', $programs);
    }

    public function scopeInCaseload($query, User $user)
    {
        $records = $user->records->pluck('id');

        return $query->whereHas('records', function ($query) use ($records) {
                    return $query->whereIn('record_id', $records);
                });
    }
}
