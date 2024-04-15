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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->unsignedBigInteger('contact_ward_id')->nullable();
            $table->string('name', 50);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('phone_number', 20);
            $table->boolean('gender')->nullable();
            $table->date('birthday');
            $table->string('detail_address', 255)->nullable();
            $table->string('avatar_url', 255)->nullable();
            $table->string('contact_detail_address', 255)->nullable();
            $table->string('contact_phone_number', 20)->nullable();
            $table->timestamp('terms_of_use_agreement_at')->nullable();
            $table->timestamp('privacy_policy_agreement_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('withdrawn_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ward_id')
                ->references('id')
                ->on('administrative_units')
                ->nullOnDelete();
            $table->foreign('contact_ward_id')
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
        Schema::dropIfExists('workers');
    }
};
