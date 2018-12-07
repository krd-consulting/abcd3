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

    public function programs()
    {
        return $this->belongsToMany('App\Program');
    }

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

            case 'program':
                $programs = $this->programs;
                break;

            default:
                $programs = [];
        }

        return $programs;
    }

    public function getScopeAttribute()
    {
        return $this->scopes()->orderBy('value', 'desc')->limit(1)->get()[0]->name;
    }

    public function scopes()
    {
        return $this->hasManyDeepFromRelations($this->roles(), (new Role)->scope());
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    public function teamPrograms()
    {
        return $this->hasManyDeepFromRelations($this->teams(), (new Team)->programs());
    }
}
