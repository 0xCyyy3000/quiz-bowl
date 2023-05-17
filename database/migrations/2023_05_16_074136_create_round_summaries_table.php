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
        Schema::create('round_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contestant')->constrained('contestants');
            $table->foreignId('round')->constrained('modes'); 
            // Rounds are the Modes. E.g. Round 1 -> Easy mode, Round 2 -> Moderate, Round 3 -> Difficult
            $table->integer('question_no');
            $table->foreignId('question_id')->constrained('questions');
            $table->boolean('round_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('round_summaries');
    }
};
