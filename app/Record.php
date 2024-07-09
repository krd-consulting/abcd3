<?php

namespace App;

use App\Group;
use App\RecordType;
use App\Team;

use App\Entity;

use Staudenmeir\EloquentHasManyDeep\HasTableAlias;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class Record extends Entity
{
    use HasTableAlias;
    use EagerLoadPivotTrait;

    protected $searchColumns = [
        'field_1_value',
        'field_2_value',
        'field_3_value',
    ];

    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachmentable');
    }

    public function assignTeam($teamId)
    {
        $this->teams()->syncWithoutDetaching($teamId);

        return $this->load('teams');
    }

    public function assignGroup(Group $group)
    {
        $model = $this->getProgramRecordPivotClass();

        $programRecord = new $model();

        $programRecord = $programRecord->withoutEvents(function() use ($group, $programRecord){
            return $programRecord->createFrom($group->program, $this, true);
        });

        $programRecord->setStatus($group->program->group_client_status->id);

        $this->teams()->syncWithoutDetaching($group->program->team->id);

        $this->groups()->attach($group);
    }

    public function assignCase(Record $case, Program $program)
    {
        $model = $case->getProgramRecordPivotClass();

        $programRecord = new $model();

        $programRecord = $programRecord->withoutEvents(function() use ($program, $case, $programRecord){
            return $programRecord->createFrom($program, $case, true);
        });

        $programRecord->setStatus($program->case_client_status->id);

        $case->teams()->syncWithoutDetaching($program->team->id);

        $this->cases()->attach($case, ['program_id' => $program->id]);
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

    public function cases_managers()
    {
        return $this->belongsToMany('App\Record', 'cases', 'record_id', 'owner_id')
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

    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    public function forms()
    {
        return $this->morphToMany('App\Form', 'model', 'model_has_forms')->withTimestamps();
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

    public function scopeAs($query, $identity) { // $records->as($identity)
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
                $teams = $user->teams->pluck('id');
                return $query->inTeams($teams);

            case 'program':
                $programs = $user->programs->pluck('id');
                return $query->inPrograms($programs);

            case 'group':
                $groups = $user->groups->pluck('id');
                return $query->inGroups($groups);

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

    public function scopeInGroups($query, $groups)
    {
        return $query
            ->leftJoin('group_record as load_group', 'records.id', 'load_group.record_id')
            ->where(function ($query) use ($groups) {
                $query->whereIn('load_group.group_id', $groups);
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
                ->leftJoin('cases', 'records.id', '=', 'cases.record_id')
                ->where(function ($query) use ($user) {
                    $query->whereColumn('records.id', 'cases.record_id')
                        ->whereIn('owner_id', $user->records()->pluck('id'));
                })->orWhereIn('records.id', $user->records()->pluck('id'));
    }

    public function scopeOnly($query, $recordType)
    {
         if(is_a($recordType, RecordType::class))
            $recordType = $recordType->id;

        return $query->where('record_type_id', $recordType);
    }
}
