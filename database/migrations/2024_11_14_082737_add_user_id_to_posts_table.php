<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add the user_id column and make it unsigned (so it can reference an ID in the users table)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Or, if you want the user to be mandatory (not nullable):
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop the foreign key and then the column itself
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
