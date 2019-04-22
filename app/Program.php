<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    public function caseRecords()
    {
        return $this->hasMany('App\CaseRecord', 'program_id');
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function program_records()
    {
        return $this->hasMany('App\ProgramRecord');
    }

    public function client_statuses()
    {
        return $this->hasManyThrough('App\ProgramClientStatus', 'App\ProgramClient', NULL, 'program_client_id');
    }

    public function records()
    {
        return $this->belongsToMany('App\Record')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->wherePivot('deleted_at', NULL)
            ->using('App\ProgramRecord');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function getAvailableRecordTypesAttribute()
    {
        return $this->records->load('record_type')->pluck('record_type')->unique();
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
        return $query->whereIn('team_id', $teams);
    }

    public function assignToTeam($team)
    {
        return $this->team()->associate($team);
    }
}
