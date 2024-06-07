<?php

namespace App;

use App\Contracts\FormReference;
use App\Contracts\FormFieldReference;
use App\Model;
use App\Record;
use App\RecordType;
use App\Traits\Models\FormReference as FormReferenceTrait;
use App\Traits\Models\Search;
use App\Traits\Models\Sort;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Group extends Entity implements FormReference, FormFieldReference
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

    public function associateRecord(RecordType $recordType, Record $record)
    {
      $this->addRecord($record);

      return $record;
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

    public function attachFormFieldReference($formEntryQueryBuilder, $formTable, $fieldColumn, $targetId) {
        return $formEntryQueryBuilder
            ->leftJoin('groups', "groups.id", '=', "$formTable.$fieldColumn")
            ->leftJoin('programs', 'programs.id' , '=', 'groups.program_id')
            ->addSelect('groups.name as field_1_reference_value')
            ->addSelect('programs.name as field_1_reference_secondary_value')
            ->addSelect(DB::Raw("CONCAT('/groups/', groups.id) as $fieldColumn".'_reference_path'));
    }

    public function getFormFieldReferenceValues($targetId, $keywords) {
        return $this
            ->search($keywords)
            ->addSelect('groups.name as label')
            ->addSelect('groups.id as value');
    }
}
