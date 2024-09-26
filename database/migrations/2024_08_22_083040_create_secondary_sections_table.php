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
        Schema::create('secondary_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_section_id');
            $table->foreign('subject_section_id')->references('id')->on('subject_sections')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_sections');
    }
};
