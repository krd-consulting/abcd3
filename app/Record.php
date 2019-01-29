<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function programs() {
        return $this->belongsToMany('App\Program')->withTimestamps();
    }

    public function teams() {
        return $this->belongsToMany('App\Team');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function record_type()
    {
        return $this->belongsTo('App\RecordType');
    }

    // Query Scopes

    public function scopeAs($query, $identity) {
        return $query->addSelect('id')
            ->addSelect('field_1_value as ' . $identity->field1->name)
            ->addSelect('field_2_value as ' . $identity->field2->name)
            ->addSelect('field_3_value as ' . $identity->field3->name);
    }

    public function scopeAvailableFor($query, $user) {
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

            default:
                return $query->inCaseLoad($user);
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

    public function scopeInCaseLoad($query, $users)
    {
        return $query->whereHas('users', function ($query) use ($users) {
                    return $query->whereIn('user_id', $users);
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

        return $query->where('field_1_value', 'LIKE' , '%' . $term . '%')
        ->orWhere('field_2_value', 'LIKE', '%' . $term . '%')
        ->orWhere('field_3_value', 'LIKE', '%' . $term . '%');
    }
}
