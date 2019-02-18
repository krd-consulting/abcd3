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
    public function scopeInTeams($query, $teams) {
        return $query->whereIn('team_id', $teams);
    }

    public function assignToTeam($team)
    {
        return $this->team()->associate($team);
    }
}
