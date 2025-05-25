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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('route_name', 255);
            $table->bigInteger('parent_id');
            $table->string('permission_name', 255);
            $table->integer('order')->comment('1, 2, 3, 4, 5, ......');
            $table->string('icon', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission_menus');
    }
};
