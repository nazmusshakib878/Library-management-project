<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('books')) {
            // Nothing to fix if table missing
            return;
        }

        if (Schema::hasColumn('books', 'title') && Schema::hasColumn('books', 'copies_total')) {
            return;
        }

        // Create temp table with correct schema
        Schema::create('books_temp', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('isbn')->nullable()->unique(false);
            $table->string('image_url')->nullable();
            $table->string('publisher')->nullable();
            $table->string('category')->nullable();
            $table->year('published_year')->nullable();
            $table->unsignedInteger('copies_total')->default(1);
            $table->unsignedInteger('copies_available')->default(1);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert using a raw statement to avoid issues with strange column names on old table
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        DB::statement('INSERT INTO books_temp (id, title, author, isbn, image_url, copies_total, copies_available, description, is_active, created_at, updated_at)
            SELECT id, NULL, NULL, isbn, image_url, 1, 1, NULL, is_active, created_at, updated_at FROM books');

        Schema::dropIfExists('books');
        Schema::rename('books_temp', 'books');

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    public function down()
    {
        // no-op: we don't attempt to restore the previous malformed structure
    }
};
