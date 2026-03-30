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
        Schema::create('tasks', function (Blueprint $table){
            $table->id(); // Primary key
            $table->string('title'); // Task title
            $table->text('description')->nullable(); // Task description, nullable
            $table->enum('status', ['todo', 'in_progress', 'completed']); // Task status
                ->default('todo'); // Default status is 'todo'
            $table->enum('priority', ['low', 'medium', 'high'])
                ->default('medium'); // Task priority with default value
            $table->date('due_date')->nullable(); // Task due date, nullable
            $table->foreignId('assigned_to')
                ->nullable() // Foreign key to users table,
                ->constrained('users')
                ->nullOnDelete('set null');
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete(); // Foreign key to users table for creator, cascade on delete
            $table->timestamps(); // Timestamps for created_at and updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
