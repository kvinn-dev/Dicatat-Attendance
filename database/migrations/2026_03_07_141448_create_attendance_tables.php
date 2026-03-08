<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'employee'])->default('employee')->after('email');
        });

        // Employees Table
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique(); // e.g., EMP-001
            $table->string('department');
            $table->string('position');
            $table->string('phone')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // Attendances Table
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in');
            $table->time('check_out')->nullable();
            $table->enum('status', ['present', 'late', 'absent'])->default('present');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('employees');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
