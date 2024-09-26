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
        Schema::create('subject_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_subject_id');
            $table->foreign('user_subject_id')->references('id')->on('user_subjects')->cascadeOnDelete();
            $table->unsignedBigInteger('user_class_id');
            $table->foreign('user_class_id')->references('id')->on('user_classes')->cascadeOnDelete();
            $table->unsignedBigInteger('primary_section_id');
            $table->foreign('primary_section_id')->references('id')->on('primary_sections')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_sections');
    }
};
