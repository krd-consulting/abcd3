<?php

namespace App;

use App\Record;
use App\User;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function records()
    {
        return $this->belongsToMany('App\Record')
            ->withTimestamps();
    }

    public function addRecord(Record $record) 
    {
        $record->programs()->syncWithoutDetaching($this->program->id);

        $this->records()->attach($record);
    }

    public function scopeAvailableFor($query, User $user) {
        $scope = $user->scope;

        switch($scope) {
            case 'universal':
                return $query;

            case 'team':
                return $query->inTeams($user);

            case 'program':
                return $query->inPrograms($user);

            default:
                return $query->inCaseload($user);
        }
    }

    public function scopeInTeams($query, User $user)
    {
        $programs = $user->teamPrograms->pluck('id');

        return $query->whereIn('program_id', $programs);
    }

    public function scopeInPrograms($query, User $user)
    {
        $programs = $user->programs->pluck('id');

        return $query->whereIn('program_id', $programs);
    }

    public function scopeInCaseload($query, User $user)
    {
        $records = $user->records->pluck('id');

        return $query->whereHas('records', function ($query) use ($records) {
                    return $query->whereIn('record_id', $records);
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
