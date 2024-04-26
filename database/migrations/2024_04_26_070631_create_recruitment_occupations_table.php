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
        Schema::create('recruitment_occupations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruitment_id');
            $table->unsignedBigInteger('occupation_id');

            $table->foreign('recruitment_id')
                ->references('id')
                ->on('recruitments')
                ->cascadeOnDelete();
            $table->foreign('occupation_id')
                ->references('id')
                ->on('occupations')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_occupations');
    }
};
