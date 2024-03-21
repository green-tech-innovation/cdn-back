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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('file')->nullable();
            $table->integer('progress')->default(0);
            $table->integer('weight');
            $table->bigInteger('amount');
            $table->date("date_start");
            $table->date("date_end");
            $table->boolean("sub_activity_is_add")->default(false);
            $table->string("report")->nullable();
            $table->boolean("report_public")->default(false);
            $table->dateTime("date_report")->nullable();

            $table->tinyInteger("approved")->default(0);
            $table->text('message')->nullable();
            $table->dateTime("date_approved")->nullable();

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
        Schema::dropIfExists('activities');
    }
};
