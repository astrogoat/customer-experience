<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCustomerExperienceChatSupportsTable extends Migration
{

    public function up(): void
    {
        Schema::create('customer_experience_chat_supports', function(Blueprint $table){
            $table->increments('id');
            $table->string('day');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('chat_is_available')->default(true);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customer_experience_chat_supports');
    }
}
