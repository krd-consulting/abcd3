<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function programs() {
        return $this->belongsToMany('App\Program');
    }

    public function teams() {
        return $this->belongsToMany('App\Team');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function file_type()
    {
        return $this->belongsTo('App\FileType');
    }

    // Query Scopes

    public function scopeAs($query, $fileType) {
        $query->addSelect('field_1_value as ' . $fileType->field1->name)
            ->addSelect('field_2_value as ' . $fileType->field2->name)
            ->addSelect('field_3_value as ' . $fileType->field3->name);
    }

    public function scopeInPrograms($query, $programs)
    {
        return $query->whereHas('programs', function ($query) use ($programs) {
                    $query->whereIn('program_id', $programs);
                });
    }

    public function scopeInTeams($query, $teams)
    {
        return $query->whereHas('teams', function ($query) use ($teams) {
                    $query->whereIn('team_id', $teams);
                });
    }

    public function scopeInCaseLoad($query, $users)
    {
        return $query->whereHas('users', function ($query) use ($users) {
                    $query->whereIn('user_id', $users);
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

        $query->orderBy($column, $ascending);
    }
}
