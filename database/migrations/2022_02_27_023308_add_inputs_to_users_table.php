<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email');
            $table->string('age')->after('phone')->nullable();
            $table->string('country')->after('age')->nullable();
            $table->string('city')->after('country')->nullable();
            $table->string('address')->after('city')->nullable();
            $table->string('facebook')->after('address')->nullable();
            $table->string('instagram')->after('facebook')->nullable();
            $table->string('image')->after('id')->nullable();
            $table->softDeletes()->after('instagram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
