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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('contact_branch_id');
            $table->unsignedBigInteger('contact_employee_id');
            $table->boolean('is_published')->default(0);
            $table->date('publish_start_date');
            $table->date('publish_end_date');
            $table->string('number', 50);
            $table->string('title', 100);
            $table->string('sub_title', 100);
            $table->text('content');
            $table->tinyInteger('salary_type');
            $table->integer('salary');
            $table->integer('monthly_salary');
            $table->integer('yearly_salary');
            $table->boolean('has_referral_fee')->default(0);
            $table->tinyInteger('referral_fee_type')->nullable();
            $table->text('referral_fee_note')->nullable();
            $table->integer('referral_fee_by_value')->nullable();
            $table->tinyInteger('referral_fee_percent')->nullable();
            $table->decimal('referral_fee_by_percent', 10, 2)->nullable();
            $table->boolean('has_refund')->default(0);
            $table->text('refund_note')->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->string('contact_phone_number', 20)->nullable();
            $table->text('holiday')->nullable();
            $table->text('welfare')->nullable();
            $table->tinyInteger('employment_type');
            $table->text('employment_note')->nullable();
            $table->tinyInteger('labor_contract_type');
            $table->string('video_url', 255)->nullable();
            $table->string('image_1_url', 255)->nullable();
            $table->string('image_2_url', 255)->nullable();
            $table->string('image_3_url', 255)->nullable();
            $table->string('image_1_caption', 100)->nullable();
            $table->string('image_2_caption', 100)->nullable();
            $table->string('image_3_caption', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->foreign('contact_branch_id')
                ->references('id')
                ->on('branches')
                ->cascadeOnDelete();
            $table->foreign('contact_employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
