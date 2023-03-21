<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('timex.tables.event.name'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('attachments')->nullable();
            $table->longText('body')->nullable();
            $table->string('category')->nullable();
            $table->date('end');
            $table->time('endTime')->nullable();
            $table->boolean('isAllDay')->default(false);
            $table->foreignUuid('organizer');
            $table->json('participants')->nullable();
            $table->longText('subject');
            $table->date('start');
            $table->time('startTime')->nullable();

            $table->timestamps();
        });

        Schema::create(config('timex.tables.category.name'), function (Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('value');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
        });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists(config('timex.tables.event.name'));
        Schema::dropIfExists(config('timex.tables.category.name'));
    }
};
