<?php

namespace App\Traits\Models;

trait FormReference {

	public function getFormReferenceTable()
    {
        return $this->getTable();
    }

    public function getFormReferenceField()
    {
        return $this->getKeyName();
    }

    public function getFormReferenceClass()
    {
        return get_class($this);
    }

}
