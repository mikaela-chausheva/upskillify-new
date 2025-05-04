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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->string('slug')->unique(); // ✅ Slug added here
        $table->text('description')->nullable();
        $table->unsignedBigInteger('teacher_id');
        $table->decimal('price', 8, 2);
        $table->boolean('is_active')->default(true);
        $table->timestamps();

        $table->foreign('teacher_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
