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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->after('name')->default('customer')
                ->comment('User role: admin, vendor, customer');

            $table->string('phone')->after('password')->nullable()
                ->comment('Optional phone number');

            $table->string('image')->after('phone')->nullable()
                ->comment('Profile picture path');

            $table->string('address')->after('image')->nullable()
                ->comment('User address');

            $table->enum('status', ['active', 'inactive'])->after('address')->default('active')
                ->comment('Account status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
