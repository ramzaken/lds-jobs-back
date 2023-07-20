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
        Schema::table('users', function ($table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->integer('role_id')->comments('0 - staff, 1 - employer');
            $table->string('address')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('post_code')->nullable();
            $table->string('mobile_number')->nullable();
            $table->text('goverment_id')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_active')->default(1);
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropColumn('address');
            $table->dropColumn('street');
            $table->dropColumn('barangay');
            $table->dropColumn('city');
            $table->dropColumn('province');
            $table->dropColumn('post_code');
            $table->dropColumn('mobile_number');
            $table->dropColumn('goverment_id');
            $table->dropColumn('is_verified');
            $table->dropColumn('is_active');
            $table->dropColumn('google_id');
            $table->dropColumn('facebook_id');
        });
    }
};
