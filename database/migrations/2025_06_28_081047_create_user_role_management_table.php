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
        Schema::create('user_role_management', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->unique(['role_id', 'user_id'], 'user_role_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_management');
    }
};
