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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained()->onDelete('cascade');
            $table->foreignId('organe_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('target');
            $table->text('goal');
            $table->text('result');
            $table->string('file');
            $table->integer('progress')->default(0);
            $table->bigInteger('cost');
            $table->date('date_start');
            $table->date('date_end');
            $table->boolean("activity_is_add")->default(false);
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
        Schema::dropIfExists('projects');
    }
};
