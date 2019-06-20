<?php

namespace App;

use App\Group;
use App\RecordType;
use App\Team;

use App\ProgramRecord;
use App\ProgramClient;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Staudenmeir\EloquentHasManyDeep\HasTableAlias;

class Record extends Model
{
    use HasTableAlias;
    use SoftDeletes;
    use Search;
    use Sort;

    protected $searchColumns = [
        'field_1_value',
        'field_2_value',
        'field_3_value',
    ];

    public function assignTeam($teamId)
    {
        $this->teams()->attach($teamId);

        return $this->load('teams');
    }

    public function assignGroup(Group $group)
    {
        $this->programs()->syncWithoutDetaching($group->program->id);

        // Update program record status.
        $this
            ->programs()
            ->where('programs.id', $group->program->id)
            ->first()
            ->pivot
            ->latestStatus
            ->updateUsing($group->program->group_client_status->id, '', true);

        $this->groups()->attach($group);
    }

    public function caseload()
    {
        return $this->cases();
    }

    public function cases()
    {
        return $this->belongsToMany('App\Record', 'cases', 'owner_id', 'record_id')
            ->withTimestamps()
            ->withPivot('program_id')
            ->using('App\CaseRecord');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')
            ->withTimestamps();
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program', 'program_record', 'record_id' ,'program_id')
            ->withTimestamps()
            ->withPivot(['id', 'enrolled_at', 'deleted_at'])
            ->wherePivot('deleted_at', NULL)
            ->using(
                $this->getProgramRecordPivotClass()
            );
    }

    public function getProgramRecordPivotClass(RecordType $recordType = NULL)
    {
        $model = $recordType == NULL ? 
                $this->record_type == NULL ? 'Record' : $this->record_type->identity->model
            : $recordType->identity->model;

        return 'App\\Program' . $model;
    }

    public function program_records()
    {
        return $this->hasMany($this->getProgramRecordPivotClass());
    }

    public function teams() {
        return $this->belongsToMany('App\Team');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function record_type()
    {
        return $this->belongsTo('App\RecordType');
    }

    public function getPathAttribute()
    {
        return "/$this->table/".$this->record_type->slug."/$this->id";
    }

    public function activePrograms()
    {
        $latestStatuses = ProgramClientStatus::selectRaw(
                "program_record_id, MAX(created_at) as max_created_at"
            )->groupBy('program_record_id');

        $programs = $this->programs()
            ->join('program_client_status as statuses', 'program_record.id', 'statuses.program_record_id')
            ->joinSub($latestStatuses, 'latest_statuses', function ($join) {
                $join
                    ->on('statuses.program_record_id', '=', 'latest_statuses.program_record_id')
                    ->on('statuses.created_at', '=', 'latest_statuses.max_created_at');
            })
            ->join('client_statuses', 'statuses.status_id', 'client_statuses.id')
            ->where('client_statuses.name', config('app.program_client_statuses.active.name'));

        return $programs;
    }

    public function activeProgramsIn(Team $team)
    {
        return $this->activePrograms()->inTeams([$team->id]);
    }

    public function isActiveInProgramsIn(Team $team)
    {
        $programs = $this->activeProgramsIn($team);

        return $programs->exists() ? $programs : false;
    }

    // Query Scopes

    public function scopeAs($query, $identity) {
        return $query->addSelect('id')
            ->addSelect('field_1_value as ' . $identity->field1->name)
            ->addSelect('field_2_value as ' . $identity->field2->name)
            ->addSelect('field_3_value as ' . $identity->field3->name);
    }

    public function scopeAvailableFor($query, $user) {
        $scope = $user->scope;

        switch($scope) {
            case 'universal':
                return $query;

            case 'team':
                $teams = $user->teams;
                return $query->inTeams($teams);

            case 'program':
                $programs = $user->programs;
                return $query->inPrograms($programs);

            case 'case load':
                return $query->inCaseloadOrSelf($user);

            case 'self':
                return $user->records;
        }
    }

    public function scopeInPrograms($query, $programs)
    {
        return $query->whereHas('programs', function ($query) use ($programs) {
                    return $query->whereIn('program_id', $programs);
                });
    }

    public function scopeInTeams($query, $teams)
    {
        return $query->whereHas('teams', function ($query) use ($teams) {
                    return $query->whereIn('team_id', $teams);
                });
    }

    public function scopeInCaseloadOrSelf($query, $user)
    {
        return $query
                ->select(
                    'records.id',
                    'field_1_value',
                    'field_2_value',
                    'field_3_value',
                    'record_type_id',
                    'records.created_at',
                    'records.updated_at'
                )
                ->leftJoin('group_record as load_group', 'records.id', 'load_group.record_id')
                ->leftJoin('cases', 'records.id', '=', 'cases.record_id')
                ->where(function ($query) use ($user) {
                    $query->whereColumn('records.id', 'cases.record_id')
                        ->whereIn('owner_id', $user->records()->pluck('id'));
                })->orWhere(function ($query) use ($user) {
                    $query->whereIn('load_group.group_id', $user->groups()->pluck('groups.id'));
                })->orWhereIn('records.id', $user->records()->pluck('id'));
    }

    public function scopeOnly($query, $recordType)
    {
         if(is_a($recordType, RecordType::class))
            $recordType = $recordType->id;

        return $query->where('record_type_id', $recordType);
    }

    public function scopeWithLatestProgramStatuses($query, RecordType $recordType, Program $program)
    {
        if($recordType->identity->model == 'Record')
            return $query;

        $recordStatusTable = 'program_' . strtolower($recordType->identity->model) . '_status';

        $model = 'App\\Program' . $recordType->identity->model . 'Status';

        $latestStatuses = $model::selectRaw(
            "program_record_id, MAX(created_at) as max_created_at"
        )->groupBy('program_record_id');

        return $query->with([
            'program_statuses' => function ($query) use ($program, $latestStatuses, $recordStatusTable) {
                $query
                    ->joinSub($latestStatuses, 'latest_statuses', function ($join) use ($recordStatusTable) {
                        $join
                            ->on($recordStatusTable.'.program_record_id', '=', 'latest_statuses.program_record_id')
                            ->on($recordStatusTable.'.created_at', '=', 'latest_statuses.max_created_at');
                    })->where('program_id', $program->id);
            }
        ]);
    }
}
