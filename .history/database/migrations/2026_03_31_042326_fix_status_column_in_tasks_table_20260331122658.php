<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixStatusColumnInTasksTable extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['todo', 'in_progress', 'done'])
                  ->default('todo')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('status')->default('todo')->change();
        });
    }
}