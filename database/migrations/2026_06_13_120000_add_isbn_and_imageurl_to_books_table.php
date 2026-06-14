<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('books')) {
            return;
        }

        if (! Schema::hasColumn('books', 'isbn')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('isbn')->nullable();
            });
        }

        if (! Schema::hasColumn('books', 'image_url')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('image_url')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('books')) {
            return;
        }

        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'image_url')) {
                $table->dropColumn('image_url');
            }
            if (Schema::hasColumn('books', 'isbn')) {
                $table->dropColumn('isbn');
            }
        });
    }
};
