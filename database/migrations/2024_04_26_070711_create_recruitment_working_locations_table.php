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
        Schema::create('working_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruitment_id');
            $table->unsignedBigInteger('ward_id');
            $table->string('detail_address', 255)->nullable();
            $table->string('map_url', 255)->nullable();
            $table->text('note')->nullable();

            $table->foreign('recruitment_id')
                ->references('id')
                ->on('recruitments')
                ->cascadeOnDelete();
            $table->foreign('ward_id')
                ->references('id')
                ->on('administrative_units')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_locations');
    }
};
