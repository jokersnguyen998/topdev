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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20);
            $table->string('name', 100);
            $table->string('representative', 50)->nullable();
            $table->string('zipcode', 6)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('ward', 50)->nullable();
            $table->string('detail_address', 255)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('homepage_url', 255)->nullable();
            $table->string('contact_person', 50);
            $table->string('contact_email', 100);
            $table->string('contact_phone_number', 20);
            $table->timestamp('suspended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
