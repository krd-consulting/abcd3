<?php

namespace App;

use App\Record;
use App\Role;
use App\Program;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

use Spatie\Permission\Traits\HasRoles;
use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

class User extends Authenticatable
{
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

    // Relationships

    public function records()
    {
        return $this->belongsToMany('App\Record');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program');
    }

    public function programRecords()
    {
        return $this->hasManyDeepFromRelations($this->programs(), (new Program)->records());
    }

    public function scopes()
    {
        return $this->hasManyDeepFromRelations($this->roles(), (new Role)->scope());
    }

    public function teamPrograms()
    {
        return $this->hasManyDeepFromRelations($this->teams(), (new Team)->programs());
    }

    public function teamRecords()
    {
        return $this->hasManyDeepFromRelations($this->teams(), (new Team)->records());
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team');
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

        return $programs;
    }

    // Getters

    public function getAvailableProgramsAttribute()
    {
        return $this->availablePrograms(null)->get();
    }

    public function getAvailableTeamsAttribute()
    {
        $teams;

        $scope = $this->scope;

        switch($scope) {
            case 'universal':
                $teams = Team::all();
                break;

            default:
                $teams = $this->teams;
                break;
        }

        return $teams;
    }

    public function getScopeAttribute()
    {
        return $this->getScope()->name;
    }

    public function getScopeValueAttribute()
    {
        return $this->getScope()->value;
    }

    public function getScope() {
        // TODO: Return default scope, if none.

        return $this->scopes()->orderBy('value', 'desc')->first();
    }

    public function hasRecord($record) : bool
    {
        if(is_a($record, Record::class))
            return $this->hasRecord($record->id);

        return $this->record()->where('file_id', $record)->exists() ||
            $this->teamRecords()->where('files.id', $record)->exists() ||
            $this->programRecords()->where('files.id', $record)->exists();
    }

    public function hasProgram($program) : bool
    {
        if(is_a($program, Program::class))
            return $this->hasProgram($program->id);

        return $this->programs()->where('program_id', $program)->exists() ||
            $this->teamPrograms()->where('programs.id', $program)->exists();
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
