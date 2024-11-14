<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // First drop the foreign key from the posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);  // Drop the foreign key constraint first
        });

        // Now drop the categories table
        Schema::dropIfExists('categories');
}

};
