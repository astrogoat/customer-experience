<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCustomerExperienceCallSupportsTable extends Migration
{

    public function up(): void
    {
        Schema::create('customer_experience_call_supports', function(Blueprint $table){
            $table->increments('id');
            $table->string('day');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('call_is_available')->default(true);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customer_experience_call_supports');
    }
}
