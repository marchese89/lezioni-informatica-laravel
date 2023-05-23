<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_on_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('trace')->nullable();
            $table->string('execution')->nullable();
            $table->integer('price')->nullable();
            $table->boolean('escaped')->default(false);
            $table->boolean('paid')->default(false);
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_on_requests');
    }
};
