<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

use App\Role;
use App\Program;

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

    public function files()
    {
        return $this->belongsToMany('App\File');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program');
    }

    public function programFiles()
    {
        return $this->hasManyDeepFromRelations($this->programs(), (new Program)->files());
    }

    public function scopes()
    {
        return $this->hasManyDeepFromRelations($this->roles(), (new Role)->scope());
    }

    public function teamPrograms()
    {
        return $this->hasManyDeepFromRelations($this->teams(), (new Team)->programs());
    }

    public function teamFiles()
    {
        return $this->hasManyDeepFromRelations($this->teams(), (new Team)->files());
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    // Query Scopes

    public function scopeHasFile($query, $file) : bool
    {
        if(is_a($file, File::class))
            return $this->hasFile($file->id);

        return $this->files()->where('file_id', $file)->exists() ||
            $this->teamFiles()->where('files.id', $file)->exists() ||
            $this->programFiles()->where('files.id', $file)->exists();
    }

    public function scopeHasProgram($query, $program) : bool
    {
        if(is_a($program, Program::class))
            return $this->hasProgram($program->id);

        return $this->programs()->where('program_id', $program)->exists() ||
            $this->teamPrograms()->where('programs.id', $program)->exists();
    }

    public function scopeHasTeam($query, $team): bool
    {
        if(is_a($team, Team::class))
            return $this->hasTeam($team->id);

        return $this->teams()->where('team_id', $team)->exists();
    }

    // Getters

    public function getAvailableProgramsAttribute()
    {
        $programs;

        $scope = $this->scope;

        switch($scope) {
            case 'universal':
                $programs = Program::all();
                break;

            case 'team':
                $programs = $this->teamPrograms;
                break;

            default:
                $programs = $this->programs;
        }

        return $programs;
    }

    public function getScopeAttribute()
    {
        return $this->getScope()->name;
    }

    public function getScopeValueAttribute()
    {
        return $this->getScope()->value;
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

    public function getScope() {
        // TODO: Return default scope, if none.

        return $this->scopes()->orderBy('value', 'desc')->first();
    }


    public function hasScopeOfAtleast($scope) : bool
    {
        if(is_numeric($scope))
            return $this->scopeValue >= $scope;

        return $this->scopeValue >= Scope::where('name', $scope)->first()->value;
    }
}
