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
        Schema::create('job_post_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('job_post_id');
            $table->unsignedBigInteger('job_id');
            $table->timestamps();
            
            $table->index(['user_id', 'staff_id', 'job_post_id', 'employer_id', 'job_id'], 'job_post_job_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_jobs');
    }
};
