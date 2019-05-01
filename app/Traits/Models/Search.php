<?php

namespace App\Traits\Models;

trait Search {

	public function scopeSearch($query, $term)
    {
        if(empty($term))
            return $query;

        foreach($this->searchColumns as $key=>$column) {
        	if($key == 0)
        		$query->where($column, 'LIKE', '%' . $term . '%');

        	$query->orWhere($column, 'LIKE', '%' . $term . '%');
        }

        return $query;
    }

}