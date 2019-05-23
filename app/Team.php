<?php

namespace App;

use App\Model;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    use Search;
    use Sort;

    protected $appends = ['path'];

    protected $searchColumns = [
        'name',
    ];
    
    public function records()
    {
        return $this->belongsToMany('App\Record');
    }

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function groups()
    {
        return $this->hasManyThrough('App\Group', 'App\Program');
    }

    public function getAvailableRecordTypesAttribute()
    {
        return $this->records->load('record_type')->pluck('record_type')->unique();
    }

    public function getPathAttribute()
    {
        return "/$this->table/$this->id";
    }

    public function scopeAvailableFor($query, $user) {
        $scope = $user->scope;

        switch($scope) {
            case 'universal':
                return $query;

            default:
                return $user->teams();
        }
    }
}
