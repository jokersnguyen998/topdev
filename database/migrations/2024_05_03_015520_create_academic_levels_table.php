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
        Schema::create('academic_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id');
            $table->smallInteger('year')->nullable();
            $table->tinyInteger('month')->nullable();
            $table->string('content', 255);
            $table->timestamps();

            $table->foreign('worker_id')
                ->references('id')
                ->on('workers')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_levels');
    }
};
