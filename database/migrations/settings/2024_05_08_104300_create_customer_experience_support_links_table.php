<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCustomerExperienceSupportLinksTable extends Migration
{

    public function up(): void
    {
        Schema::create('customer_experience_support_links', function(Blueprint $table){
            $table->increments('id');
            $table->string('link_copy')->nullable();
            $table->string('link_url')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customer_experience_support_links');
    }
}
