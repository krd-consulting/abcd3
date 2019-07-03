<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public function target_type()
    {
    	return $this->belongsTo('App\FormTargetType');
    }

    public function target()
    {
    	return $this->belongsTo($this->target_type->model);
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')
            ->withTimestamps();
    }

    public function programs()
    {
        return $this->belongsToMany('App\Programs')
            ->withTimestamps();
    }

    public function scopeAvailableFor($query, $user) {
        return $query;

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
                return $user->forms;
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
}
