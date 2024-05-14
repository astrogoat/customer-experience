<?php

namespace Astrogoat\CustomerExperience\Models;

use Illuminate\Database\Eloquent\Model;

class CxChat extends Model
{
    protected $table = 'customer_experience_chat_supports';

    protected $guarded = [];

    public $timestamps = false;
}
