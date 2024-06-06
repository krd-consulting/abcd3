<?php

namespace App;

use App\Model;

use App\Contracts\FormReference;
use App\Contracts\FormFieldReference;
use App\Traits\Models\Active;
use App\Traits\Models\FormReference as FormReferenceTrait;
use Illuminate\Contracts\Routing\UrlRoutable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\DB;

class RecordType extends Model implements FormReference, UrlRoutable, FormFieldReference
{
    use HasSlug, FormReferenceTrait, Active;

    public function records()
    {
        return $this->hasMany('App\Record');
    }

    public function identity()
    {
        return $this->belongsTo('App\RecordIdentity');
    }

    /**
     * Returns a key-value pair of the fields of a RecordType's identity.
     *
     * @return array The key is the record's database column name and the
     * value is the type of record field it is associated to (via record identity).
     */
    public function getFieldsAttribute()
    {
        $fields = array();

        if($this->identity == null) {
            throw new Exception('Record Identity not loaded.', 1);
        }

        for($field = 1; $field <= 3; $field++) {
            $column = 'field' . $field;

            if($this->identity->$column != null) {
                $fields['field_' . $field . '_value'] = $this->identity->$column;
            }
        }

        return $fields;
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
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
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

    public function getFormReferenceClass()
    {
        return 'App\Record';
    }

    public function attachFormFieldReference(
        $formEntryQueryBuilder, 
        $formTable, 
        $fieldColumn,
        $targetId) {
        return $formEntryQueryBuilder
            ->leftJoin('records', "records.id", '=', "$formTable.$fieldColumn")
            ->leftJoin('record_types', 'record_types.id', '=', 'records.record_type_id')
            ->where('record_types.id' , '=', $targetId)
            ->addSelect(DB::Raw("CONCAT(records.field_1_value, ' ', records.field_2_value) as field_1_reference_value"))
            ->addSelect('record_types.name as field_1_reference_secondary_value');
    }

    public function getFormFieldReferenceValues($targetId) {
        return $this
            ->leftJoin('records', 'records.record_type_id', '=', 'record_types.id')
            ->where('record_types.id', '=', $targetId)
            ->addSelect(DB::Raw("CONCAT(records.field_1_value, ' ', records.field_2_value) as value"));
    }
}
