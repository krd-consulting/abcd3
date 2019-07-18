<?php

namespace App;

use App\Model;

use App\Contracts\FormReference;
use App\Traits\Models\FormReference as FormReferenceTrait;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RecordType extends Model implements FormReference
{
    use HasSlug, FormReferenceTrait;

    public function records()
    {
        return $this->hasMany('App\Record');
    }

    public function identity()
    {
        return $this->belongsTo('App\RecordIdentity');
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

    public function getFormReferenceTable()
    {
        return $this->records()->getRelated()->getTable();
    }
}
