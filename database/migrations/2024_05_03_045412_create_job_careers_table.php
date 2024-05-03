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
        Schema::create('job_careers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skill_id');
            $table->string('company_name', 100);
            $table->string('department_name', 50)->nullable();
            $table->smallInteger('year');
            $table->tinyInteger('month');
            $table->boolean('is_retired');
            $table->mediumText('environment')->nullable();
            $table->mediumText('role')->nullable();
            $table->mediumText('technique')->nullable();
            $table->timestamps();

            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_careers');
    }
};
