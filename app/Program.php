<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    public function records()
    {
        return $this->belongsToMany('App\Record')
            ->withTimestamps()
            ->withPivot('notes', 'status', 'status_updated_at')
            ->using('App\ProgramRecord');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    // Query Scopes
    public function scopeAvailableFor($query, $user) {
        $scope = $user->scope;

        switch($scope) {
            case 'universal':

                return $query;

            case 'team':

                $teams = $user->teams;
                return $query->inTeams($teams);

            default:
                return $user->programs();
        }
    }

    public function scopeInTeams($query, $teams) {
        return $query->whereIn('team_id', $teams);
    }

    public function assignToTeam($team)
    {
        return $this->team()->associate($team);
    }
}
