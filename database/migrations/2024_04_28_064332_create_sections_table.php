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
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("courses_id")->unsigned()->nullable();
            $table->foreign('courses_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string("title_ar")->nullable();
            $table->string("title_en")->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('is_paid')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
