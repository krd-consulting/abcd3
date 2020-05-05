<?php

namespace App;

use App\Record;
use App\Role;
use App\Scope;
use App\Program;
use App\Group;
use App\ProgramRecord;
use App\TeamRecord;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Traits\HasRoles;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as HasAuditable;

class User extends Authenticatable implements Auditable
{
    use HasAuditable;
    use Notifiable;
    use HasRoles;
    use HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cases()
    {
        return $this->hasManyDeep('App\Record', ['App\Record as case_owners','cases'], [null ,'owner_id']);
    }

    public function case_records()
    {
        return $this->hasManyThrough('App\CaseRecord', 'App\Record', null, 'owner_id');
    }

    public function groups()
    {
        return $this->hasManyDeep('App\Group', ['App\Record', 'group_record']);
    }

    public function teamGroups()
    {
        return $this->hasManyDeepFromRelations(
            $this->teamPrograms(),
            (new Program)->groups()
        );
    }

    public function programGroups()
    {
        return $this->hasManyDeepFromRelations(
            $this->programs(),
            (new Program)->groups()
        );
    }

    public function records()
    {
        return $this->hasMany('App\Record');
    }

    public function scopes()
    {
        return $this->hasManyDeepFromRelations($this->roles(), (new Role)->scope());
    }

    public function programs()
    {
        return $this->hasManyDeepFromRelations($this->records(), (new Record)->programs());
    }

    public function teamPrograms()
    {
        return $this->hasManyDeep('App\Program', ['App\Record', 'record_team', 'App\Team']);
    }

    public function teams()
    {
        return $this->hasManyDeepFromRelations($this->records(), (new Record)->teams());
    }

    public function forms()
    {
        return $this->hasManyDeepFromRelations($this->records(), (new Record)->forms());
    }

    public function availableTeams(?int $limit)
    {
        $teams;

        $scope = $this->scope;

        switch($scope) {
            case 'universal':
                $teams = new Team;
                break;

            default:
                $teams = $this->teams();
                break;
        }

        if(isset($limit)) {
            $teams = $teams->limit($limit);
        }

        return $teams;
    }

    public function availablePrograms(?int $limit)
    {
        $programs;

        $scope = $this->scope;

        switch($scope) {
            case 'universal':
                $programs = new Program;
                break;

            case 'team':
                $programs = $this->teamPrograms();
                break;

            default:
                $programs = $this->programs();
        }

        if(isset($limit)) {
            $programs = $programs->limit($limit);
        }

        return $programs->active(true);
    }

    public function availableGroups(?int $limit)
    {
        $groups;

        $scope = $this->scope;

        switch($scope) {
            case 'universal':
                $groups = new Group;
                break;

            case 'team':
                $groups = $this->teamGroups();
                break;

            case 'program':
                $groups = $this->programGroups();
                break;

            default:
                $groups = $this->groups();
        }

        if(isset($limit)) {
            $groups = $groups->limit($limit);
        }

        return $groups;
    }

    // Getters

    public function getAvailableProgramsAttribute()
    {
        return $this->availablePrograms(null)->get();
    }

    public function getAvailableTeamsAttribute()
    {
        return $this->availableTeams(null)->get();
    }

    public function getAvailableGroupsAttribute()
    {
        return $this->availableGroups(null)->get();
    }

    public function getScopeAttribute()
    {
        if(empty($this->getScope()))
            return config('auth.scopes.self.name');

        return $this->getScope()->name;
    }

    public function getScopeValueAttribute()
    {
        if(empty($this->getScope()))
            return config('auth.scopes.self.value');

        return $this->getScope()->value;
    }

    public function getScope() {
        return $this->scopes()->orderBy('value', 'desc')->first();
    }

    public function hasRecord($record) : bool
    {
        if(is_a($record, Record::class))
            return $this->hasRecord($record->id);

        return $this->records()->where('id', $record)->exists() ||
            $this->cases()->where('record_id', $record)->exists() ||
            $this->hasProgramRecord($record) ||
            $this->hasTeamRecord($record);
    }

    public function hasProgramRecord($record_id, bool $checkScope = true) : bool
    {
        if($checkScope) {
            if(!$this->hasScopeOfAtleast(3))
                return false;
        }

        return ProgramRecord::whereIn('program_id', $this->programs)->where('record_id', $record_id)->exists();
    }

    public function hasTeamRecord($record_id, bool $checkScope = true) : bool
    {
        if($checkScope) {
            if(!$this->hasScopeOfAtleast(4))
                return false;
        }

        return TeamRecord::whereIn('team_id', $this->teams->pluck('id'))->where('record_id', $record_id)->exists();
    }

    public function hasProgram($program) : bool
    {
        if(is_a($program, Program::class))
            return $this->hasProgram($program->id);

        return $this->programs()->where('program_id', $program)->exists() ||
            $this->hasTeamProgram($program, true);
    }

    public function hasTeamProgram($program, bool $checkScope = true) : bool
    {
        if($checkScope) {
            if(!$this->hasScopeOfAtleast(4))
                return false;
        }

        return $this->teamPrograms()->where('programs.id', $program)->exists();
    }

    public function hasGroup($group)
    {
        if(is_a($group, Group::class))
            return $this->hasGroup($group->id);

        return $this->programs()->whereHas('groups', function($query) use ($group) {
                return $query->where('groups.id', $group);
            })->exists() || $this->hasTeamGroup($group);
    }

    public function hasTeamGroup($group, bool $checkScope = true) : bool
    {
        if($checkScope) {
            if(!$this->hasScopeOfAtleast(4))
                return false;
        }

        return $this->teamPrograms()->whereHas('groups', function($query) use ($group) {
            return $query->where('groups.id', $group);
        })->exists();
    }

    public function hasScopeOfAtleast($scope) : bool
    {
        if(is_numeric($scope))
            return $this->scopeValue >= $scope;

        return $this->scopeValue >= Scope::where('name', $scope)->first()->value;
    }

    public function hasTeam($team): bool
    {
        if(is_a($team, Team::class))
            return $this->hasTeam($team->id);

        return $this->teams()->where('team_id', $team)->exists();
    }
}
