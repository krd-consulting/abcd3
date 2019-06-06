<?php

namespace App;

use App\Group;
use App\RecordType;
use App\Team;

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
        return $this->belongsToMany('App\Program')
            ->withTimestamps()
            ->withPivot(['enrolled_at', 'deleted_at'])
            ->wherePivot('deleted_at', NULL)
            ->using('App\ProgramRecord');
    }

    public function program_records()
    {
        return $this->hasMany('App\ProgramRecord');
    }

    public function client_statuses()
    {
        return $this->hasManyThrough('App\ProgramClientStatus', 'App\ProgramClient', NULL, 'program_client_id');
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

    public function isActiveInProgram(Team $team)
    {
        return $this->program_records()
            ->leftJoin('program_client_status', 'program_client_id', 'program_record.id')
            ->leftJoin('client_statuses', 'program_client_status.status_id', 'client_statuses.id')
            ->leftJoin('programs', 'program_record.program_id', 'programs.id')
            ->leftJoin('teams', 'programs.team_id', 'teams.id')
            ->orderBy('program_client_status.created_at', 'desc')
            ->select('client_statuses.name')
            ->where('teams.id', $team->id)
            ->first()
            ->name == config('app.program_client_statuses.active.name'); 
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
                ->leftJoin('cases', 'records.id', '=', 'cases.record_id')
                ->where(function ($query) use ($user) {
                    $query->whereColumn('records.id', 'cases.record_id')
                        ->whereIn('owner_id', $user->records->pluck('id'));
                })->orWhereIn('records.id', $user->records->pluck('id'));
    }

    public function scopeOnly($query, $recordType)
    {
         if(is_a($recordType, RecordType::class))
            $recordType = $recordType->id;

        return $query->where('record_type_id', $recordType);
    }
}
