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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Add isAdmin if it doesn't exist
                if (! Schema::hasColumn('users', 'isAdmin')) {
                    $table->boolean('isAdmin')->default(false)->nullable();
                }

                // Add student_id if it doesn't exist
                if (! Schema::hasColumn('users', 'student_id')) {
                    $table->string('student_id')->nullable()->unique();
                }

                // Add department if it doesn't exist
                if (! Schema::hasColumn('users', 'department')) {
                    $table->string('department')->nullable();
                }

                // Add phone if it doesn't exist
                if (! Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable();
                }
            });
        }

        if (Schema::hasTable('books')) {
            Schema::table('books', function (Blueprint $table) {
                // Add is_active if it doesn't exist
                if (! Schema::hasColumn('books', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally drop columns
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'isAdmin')) {
                    $table->dropColumn('isAdmin');
                }
                if (Schema::hasColumn('users', 'student_id')) {
                    $table->dropUnique(['student_id']);
                    $table->dropColumn('student_id');
                }
                if (Schema::hasColumn('users', 'department')) {
                    $table->dropColumn('department');
                }
                if (Schema::hasColumn('users', 'phone')) {
                    $table->dropColumn('phone');
                }
            });
        }

        if (Schema::hasTable('books')) {
            Schema::table('books', function (Blueprint $table) {
                if (Schema::hasColumn('books', 'is_active')) {
                    $table->dropColumn('is_active');
                }
            });
        }
    }
};
