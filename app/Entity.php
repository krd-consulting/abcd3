<?php

namespace App;

use App\Model;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;
use App\Traits\Models\Active;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;
    use Search;
    use Sort;
}
