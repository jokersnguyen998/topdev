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
        Schema::create('latest_recruitments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruitment_id');
            $table->unsignedBigInteger('company_id');
            $table->string('number', 50)->unique();

            $table->foreign('recruitment_id')
                ->references('id')
                ->on('recruitments')
                ->cascadeOnDelete();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('latest_recruitments');
    }
};
