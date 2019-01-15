<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RecordType extends Model
{
    use HasSlug;

    public function field1() {
        return $this->hasOne('App\Field', 'id', 'field_1_id');
    }

    public function field2() {
        return $this->hasOne('App\Field', 'id', 'field_2_id');
    }

    public function field3() {
        return $this->hasOne('App\Field', 'id', 'field_3_id');
    }

    public function records()
    {
        return $this->hasMany('App\Record');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
