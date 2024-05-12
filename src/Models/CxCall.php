<?php

namespace Astrogoat\CustomerExperience\Models;

use Illuminate\Database\Eloquent\Model;

class CxCall extends Model
{
    protected $table = 'customer_experience_call_supports';

    protected $guarded = [];

    public $timestamps = false;
}
