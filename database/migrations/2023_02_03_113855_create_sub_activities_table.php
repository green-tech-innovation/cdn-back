<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('file')->nullable();
            $table->integer('progress')->default(0);
            $table->integer('weight');
            $table->bigInteger('amount');
            $table->string("report")->nullable();
            $table->dateTime("date_report")->nullable();

            $table->tinyInteger("approved")->default(0);
            $table->text('message')->nullable();
            $table->dateTime("date_approved")->nullable();

            $table->date("date_start");
            $table->date("date_end");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_activities');
    }
};
