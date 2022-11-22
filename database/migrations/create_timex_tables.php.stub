<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('timex_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('body')->nullable();
            $table->string('category')->nullable();
            $table->date('end');
            $table->time('endTime');
            $table->boolean('isAllDay')->default(false);
            $table->foreignUuid('organizer');
            $table->longText('subject');
            $table->date('start');
            $table->time('startTime');

            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('timex_events');
    }
};
