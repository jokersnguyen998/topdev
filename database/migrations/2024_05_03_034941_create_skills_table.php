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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id');
            $table->mediumText('work_summary')->nullable();
            $table->mediumText('specialty')->nullable();
            $table->mediumText('tools')->nullable();
            $table->mediumText('self_promotion')->nullable();
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
        Schema::dropIfExists('skills');
    }
};
