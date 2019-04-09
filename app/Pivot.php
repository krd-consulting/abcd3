<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot as EloquentPivot;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as HasAuditable;

class Pivot extends EloquentPivot implements Auditable
{
    use HasAuditable;
}
