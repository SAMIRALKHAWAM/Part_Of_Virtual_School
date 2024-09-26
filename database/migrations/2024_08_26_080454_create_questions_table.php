<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_section_id');
            $table->foreign('exam_section_id')->references('id')->on('exam_sections')->cascadeOnDelete();
            $table->unsignedBigInteger('question_type_id');
            $table->foreign('question_type_id')->references('id')->on('question_types')->cascadeOnDelete();
            $table->mediumText('question');
            $table->string('file')->nullable();
            $table->integer('mark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
