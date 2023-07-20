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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employer_id');
            $table->string('job_headline');
            $table->string('job_title');
            $table->decimal('fixed_rate', 18,2)->nullable();
            $table->decimal('rate_min', 18,2)->nullable();
            $table->decimal('rate_max', 18,2)->nullable();
            $table->integer('employment_type')->comments('0 - full time, 1 - part time');
            $table->longText('description');
            $table->integer('work_schedule')->comments('0 - fixed, 1 - flexible');
            $table->integer('fixed_hour')->nullable();
            $table->integer('hour_min')->nullable();
            $table->integer('hour_max')->nullable();
            $table->boolean('terms_and_privacy_policy')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->index(['user_id', 'employer_id'], 'job_post_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
