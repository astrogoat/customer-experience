<?php

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('customer_experience_opening_hours', function(Blueprint $table){
            $table->increments('id');
            $table->integer('day');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->string('type');
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customer_experience_opening_hours');
    }
};
