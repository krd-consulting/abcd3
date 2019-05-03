<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as HasAuditable;

class Model extends EloquentModel implements Auditable
{
    use HasAuditable;

    protected $guarded = [];
}
