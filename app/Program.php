<?php

namespace App;

use App\Contracts\FormReference;
use App\Entity;
use App\Record;
use App\RecordIdentity;
use App\RecordType;
use App\Traits\Models\FormReference as FormReferenceTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Entity implements FormReference
{
    use FormReferenceTrait;

    private $recordType;

    public function caseRecords()
    {
        return $this->hasMany('App\CaseRecord', 'program_id');
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function forms()
    {
        return $this->morphToMany('App\Form', 'model', 'model_has_forms')->withTimestamps();
    }

    public function program_records()
    {
        return $this->hasMany('App\ProgramRecord');
    }

    public function record_statuses()
    {
        return empty($this->client_statuses()) ? NULL : $this->client_statuses();
    }

    public function client_statuses()
    {
        return $this->hasManyThrough(
            'App\ProgramClientStatus',
            'App\ProgramClient',
            'program_id',
            'program_record_id'
        );
    }

    public function default_client_status()
    {
        return $this->belongsTo('App\ClientStatus');
    }

    public function group_client_status()
    {
        if(!$this->belongsTo('App\ClientStatus')->exists())
            return $this->default_client_status();

        return $this->belongsTo('App\ClientStatus');
    }

    public function case_client_status()
    {
        if(!$this->belongsTo('App\ClientStatus')->exists())
            return $this->default_client_status();

        return $this->belongsTo('App\ClientStatus');
    }

    public function records(RecordIdentity $recordIdentity = null)
    {
        $model = 'Record';

        if(!empty($recordIdentity))
            $model = $recordIdentity->model;

        return $this->belongsToMany("App\\$model", 'program_record', 'program_id' ,'record_id')
            ->withTimestamps()
            ->withPivot(['id', 'enrolled_at', 'deleted_at'])
            ->wherePivot('deleted_at', NULL)
            ->using("App\Program$model");
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    // Created to prevent EntityTypeFormsController::index
    // from crashing as it assumes relationships
    // between collections are plural.
    public function teams()
    {
        return $this->team();
    }

    public function getAvailableRecordTypesAttribute()
    {
        return $this->records->load('record_type')->pluck('record_type')->unique();
    }

    public function getPathAttribute()
    {
        return "/$this->table/$this->id";
    }

    // Query Scopes
    public function scopeAvailableFor($query, $user, $exceptions = []) {
        $scope = $user->scope;

        switch($scope) {
            case 'universal':
                return $query->whereNotIn('id', $exceptions);

            case 'team':
                $teams = $user->teams;
                return $query->whereNotIn('id', $exceptions)->inTeams($teams);

            default:
                return $user->programs()->whereNotIn('id', $exceptions);
        }
    }

    public function scopeSort($query, $column, $ascending)
    {
        if(empty($column))
            return ;

        if($ascending == 'true')
            $ascending = 'asc';
        else
            $ascending = 'desc';

        return $query->orderBy($column, $ascending);
    }

    public function scopeSearch($query, $term)
    {
        if(empty($term))
            return $query;

        return $query->where('name', 'LIKE' , '%' . $term . '%')
        ->orWhere('description', 'LIKE', '%' . $term . '%');
    }

    public function scopeInTeams($query, $teams) {
        $table = $this->getTable();

        return $query->whereIn("$table.team_id", $teams);
    }

    public function scopeWithLatestRecordStatuses($query, Record $record)
    {
        if($record->record_type->identity->model == 'Record')
            return $query;

        $recordStatusTable = 'program_' . strtolower($record->record_type->identity->model) . '_status';

        $model = 'App\\Program' . $record->record_type->identity->model . 'Status';

        $latestStatuses = $model::selectRaw(
            "program_record_id, MAX(created_at) as max_created_at"
        )->groupBy('program_record_id');

        return $query->with([
            'record_statuses' => function ($query) use ($record, $latestStatuses, $recordStatusTable) {
                $query
                    ->joinSub($latestStatuses, 'latest_statuses', function ($join) use ($recordStatusTable) {
                        $join
                            ->on($recordStatusTable.'.program_record_id', '=', 'latest_statuses.program_record_id')
                            ->on($recordStatusTable.'.created_at', '=', 'latest_statuses.max_created_at');
                    })->where('record_id', $record->id);
            }
        ]);
    }

    public function assignToTeam($team)
    {
        return $this->team()->associate($team);
    }

    public function associateRecord(RecordType $recordType, Record $record)
    {
      $programRecord = $this->getRecordPivotModel($recordType);

      $programRecord = new $programRecord();
      $programRecord->createFrom($this, $record, true, null);

      return $record;
    }

    private function getRecordPivotModel(RecordType $recordType)
    {
        return "App\Program" . $recordType->identity->model;
    }
}
