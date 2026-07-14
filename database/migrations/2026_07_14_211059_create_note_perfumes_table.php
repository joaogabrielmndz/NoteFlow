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
        Schema::create('note_perfume', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfume_id')->constrained('perfumes', 'id')->cascadeOnDelete();
            $table->foreignId('note_id')->constrained('notes', 'id')->cascadeOnDelete();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_perfume');
    }
};
