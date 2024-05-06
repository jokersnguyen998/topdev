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
        Schema::create('referral_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('worker_id');
            $table->timestamp('published_resume_at')->nullable();
            $table->timestamp('published_experience_at')->nullable();
            $table->timestamp('requested_to_enter_resume_at')->nullable();
            $table->timestamp('completed_resume_at')->nullable();
            $table->boolean('is_first')->default(0);
            $table->text('memo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('referral_connections');
    }
};
