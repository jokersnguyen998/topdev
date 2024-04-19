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
        Schema::create('company_job_introduction_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->string('license_number_1', 4);
            $table->string('license_number_2', 1);
            $table->string('license_number_3', 4);
            $table->string('license_url', 255);
            $table->date('issue_date');
            $table->date('expired_date');
            $table->boolean('is_excellent_referral')->default(0);
            $table->string('detail_url', 255)->nullable();
            $table->string('detail_address', 255)->nullable();
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->foreign('ward_id')
                ->references('id')
                ->on('administrative_units')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_job_introduction_licenses');
    }
};
