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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email');//->primary();
            $table->string('password');
            $table->string('name')->nullable();;
            $table->string('surname')->nullable();;
            $table->date('last_access')->nullable();
            $table->string('cf',16)->nullable();
            $table->string('photo')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number',10)->nullable();
            $table->string('city')->nullable();
            $table->string('province',2)->nullable();
            $table->string('postal_code',5)->nullable();
            $table->string('piva',11)->nullable();
            $table->string('stripe_private_key')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
