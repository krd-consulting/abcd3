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
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return 
            $this
                ->where('id', $value)
                ->orWhere('slug', $value)
                ->first() ?? abort(404);
    }

    public function getFormReferenceTable()
    {
        return $this->records()->getRelated()->getTable();
    }
}
