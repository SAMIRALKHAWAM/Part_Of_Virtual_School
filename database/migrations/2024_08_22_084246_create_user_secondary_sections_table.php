<?php

use App\Enums\OrderStatusEnum;
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
        Schema::create('user_secondary_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->foreign('actor_id')->references('id')->on('actors')->cascadeOnDelete();
            $table->unsignedBigInteger('secondary_section_id');
            $table->foreign('secondary_section_id')->references('id')->on('secondary_sections')->cascadeOnDelete();
            $table->decimal('price');
            $table->string('status')->default(OrderStatusEnum::Pending);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_secondary_sections');
    }
};
