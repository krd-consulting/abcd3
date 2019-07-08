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

    public function teams()
    {
        return $this->belongsToMany('App\Team')
            ->withTimestamps();
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program')
            ->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')
            ->withTimestamps();
    }

    public function scopeAvailableFor($query, $user) {
        $universal = $query;
        $teams = (clone $query)->inTeams($user->teams);
        $programs = (clone $query)->inPrograms($user->programs);
        $groups = (clone $query)->inGroups($user->groups);
        $self = (clone $query)->inSelf($user);

        return 
            $universal
                ->union($teams);
                // ->union($programs)
                // ->union($groups)
                // ->union($self);
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

    public function scopeInSelf($query, $user)
    {
        return $query
                ->select(
                    'forms.id',
                    'field_1_value',
                    'field_2_value',
                    'field_3_value',
                    'record_type_id',
                    'forms.created_at',
                    'forms.updated_at'
                )
                ->leftJoin('cases', 'forms.id', '=', 'cases.record_id')
                ->where(function ($query) use ($user) {
                    $query->whereColumn('forms.id', 'cases.record_id')
                        ->whereIn('owner_id', $user->forms()->pluck('id'));
                })->orWhereIn('forms.id', $user->forms()->pluck('id'));
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
