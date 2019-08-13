<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Models\Search;
use App\Traits\Models\Sort;

class FormEntry extends Model
{
    use Search;
    use Sort;

    public $searchColumns = [];
}
