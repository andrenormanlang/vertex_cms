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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title', 1000)->change(); // Increase from 255 to 500 or higher if needed
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title', 255)->change(); // Revert back if needed
        });
    }
};
