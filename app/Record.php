<?php

namespace App;

use App\RecordType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Staudenmeir\EloquentHasManyDeep\HasTableAlias;

class Record extends Model
{
    use HasTableAlias;
    use SoftDeletes;

    public function assignTeam($teamId)
    {
        $this->teams()->attach($teamId);

        return $this->load('teams');
    }

    public function caseload()
    {
        return $this->cases();
    }

    public function cases()
    {
        return $this->belongsToMany('App\Record', 'cases', 'owner_id', 'record_id')
            ->withTimestamps()
            ->withPivot('program_id', 'created_by')
            ->using('App\CaseRecord');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')
            ->withTimestamps()
            ->withPivot('enrolled_at', 'end', 'created_by', 'updated_by');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program')
            ->withTimestamps()
            ->withPivot('created_by')
            ->using('App\ProgramRecord');
    }

    public function program_records()
    {
        return $this->hasMany('App\ProgramRecord');
    }

    public function program_statuses()
    {
        return $this->hasManyThrough('App\ProgramClientStatus', 'App\ProgramRecord', NULL, 'program_client_id');
    }

    public function teams() {
        return $this->belongsToMany('App\Team');
    }

    public function user() {
        return $this->belongsTo('App\User');
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
                return $query->inCaseload($user->records);
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

    public function scopeInCaseload($query, $owners)
    {
        return $query->join('cases', 'records.id', '=', 'cases.record_id')
                ->whereColumn('records.id', 'cases.record_id')
                ->whereIn('owner_id', $owners);
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

    public function scopeOnly($query, $recordType)
    {
         if(is_a($recordType, RecordType::class))
            $recordType = $recordType->id;

        return $query->where('record_type_id', $recordType);
    }
}
