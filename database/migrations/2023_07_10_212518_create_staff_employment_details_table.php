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
        Schema::create('staff_employment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('staff_id');
            $table->string('company_name');
            $table->string('company_address');
            $table->date('month_start');
            $table->date('year_start');
            $table->date('month_end');
            $table->date('year_end');
            $table->timestamps();

            $table->index(['user_id', 'staff_id'], 'staff_employment_detail_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_employment_details');
    }
};
