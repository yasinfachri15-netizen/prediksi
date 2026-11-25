<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_training_runs', function (Blueprint $table) {
            $table->id();
            $table->string('trained_by')->nullable();
            $table->unsignedInteger('training_samples');
            $table->unsignedInteger('evaluation_samples')->nullable();
            $table->string('evaluation_method')->nullable();
            $table->json('evaluation_metrics')->nullable();
            $table->json('parameters');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_training_runs');
    }
};
