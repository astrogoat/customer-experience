<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCustomerExperienceFaqsTable extends Migration
{

    public function up(): void
    {
        Schema::create('customer_experience_faqs', function(Blueprint $table){
            $table->increments('id');
            $table->string('faq_question');
            $table->longText('faq_answer');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customer_experience_faqs');
    }
}
