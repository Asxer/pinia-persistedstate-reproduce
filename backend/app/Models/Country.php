<?php

namespace App\Models;

use Artel\Support\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use ModelTrait;

    protected $fillable = [
        'name',
    ];

    protected $hidden = ['pivot'];
}
