<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("courses_id")->unsigned()->nullable();
            $table->foreign('courses_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string("title_ar")->nullable();
            $table->string("title_en")->nullable();
            $table->string('description_ar', 500)->nullable();
            $table->string('description_en', 500)->nullable();
            $table->string("image")->nullable();
            $table->string("path")->nullable();
            $table->string("type")->nullable();
            $table->string("size")->nullable();
            $table->string("duration")->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viedos');
    }
};
