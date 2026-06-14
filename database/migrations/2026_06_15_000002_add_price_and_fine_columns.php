<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('books') && ! Schema::hasColumn('books', 'price')) {
            Schema::table('books', function (Blueprint $table) {
                $table->decimal('price', 10, 2)->default(0)->after('isbn');
            });
        }

        if (Schema::hasTable('book_issues')) {
            Schema::table('book_issues', function (Blueprint $table) {
                if (! Schema::hasColumn('book_issues', 'fine_per_day')) {
                    $table->decimal('fine_per_day', 10, 2)->default(10)->after('return_date');
                }

                if (! Schema::hasColumn('book_issues', 'fine_amount')) {
                    $table->decimal('fine_amount', 10, 2)->default(0)->after('fine_per_day');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('book_issues')) {
            Schema::table('book_issues', function (Blueprint $table) {
                if (Schema::hasColumn('book_issues', 'fine_amount')) {
                    $table->dropColumn('fine_amount');
                }

                if (Schema::hasColumn('book_issues', 'fine_per_day')) {
                    $table->dropColumn('fine_per_day');
                }
            });
        }

        if (Schema::hasTable('books') && Schema::hasColumn('books', 'price')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('price');
            });
        }
    }
};

