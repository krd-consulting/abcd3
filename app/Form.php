<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Scope;

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

    public function users()
    {
        return $this->belongsToMany('App\User')
            ->withTimestamps();
    }

    public function scopeAvailableFor($query, $user) {
        $universal = 
            (clone $query)
                ->where('scope_id', Scope::where('name', config('auth.scopes.universal.name'))->first()->id);
        $teams = (clone $query)->inTeams($user->availableTeams);
        $programs = (clone $query)->inPrograms($user->availablePrograms);
        $groups = (clone $query)->inGroups($user->availableGroups);
        $self = (clone $query)->inSelf($user);

        $query = 
            $universal
                ->union($teams)
                ->union($programs)
                ->union($groups)
                ->union($self);

        return $query;
    }

    public function scopeInTeams($query, $teams)
    {
        return 
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.team.name'))->first()->id)
                ->whereHas('teams', function ($query) use ($teams) {
                    return $query->whereIn('team_id', $teams->pluck('id'));
                });
    }

    public function scopeInPrograms($query, $programs)
    {
        return 
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.program.name'))->first()->id)
                ->whereHas('programs', function ($query) use ($programs) {
                    return $query->whereIn('program_id', $programs->pluck('id'));
                });
    }

    public function scopeInGroups($query, $groups)
    {
        return 
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.group.name'))->first()->id)
                ->whereHas('groups', function ($query) use ($groups) {
                    return $query->whereIn('group_id', $groups->pluck('id'));
                });
    }

    public function scopeInSelf($query, $user)
    {
        return 
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.self.name'))->first()->id)
                ->whereHas('users', function ($query) use ($user) {
                    return $query->where('user_id', $user);
                });
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
