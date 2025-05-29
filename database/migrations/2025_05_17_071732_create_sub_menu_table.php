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
        Schema::create('sub_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->default(0);
            $table->string('name', 255);
            $table->string('display_name', 255);
            $table->string('controller_name')->default(0);
            $table->string('method_name')->default(0);
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
        Schema::dropIfExists('role_permission_sub_menus');
    }
};
