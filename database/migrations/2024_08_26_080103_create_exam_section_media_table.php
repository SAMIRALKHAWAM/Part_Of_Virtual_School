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
        Schema::create('exam_section_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_section_id');
            $table->foreign('exam_section_id')->references('id')->on('exam_sections')->cascadeOnDelete();
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_section_media');
    }
};
