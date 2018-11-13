<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function teams() {
        return $this->belongsToMany('App\Team');
    }

    public function file_type()
    {
        return $this->belongsTo('App\FileType');
    }

    // Query Scopes
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
