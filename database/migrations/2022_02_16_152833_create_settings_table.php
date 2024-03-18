<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('phone');
            $table->text('map');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'email' => 'info@crafty-workshop.com',
            'phone' => 'tel:+201557831370',
            'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.12404901033!2d31.342797015451485!3d30.06197852469832!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583e7228cb188b%3A0x703d99e90c6fd3f9!2sMakram%20Ebeid%2C%20Al%20Manteqah%20as%20Sadesah%2C%20Nasr%20City%2C%20Cairo%20Governorate!5e0!3m2!1sen!2seg!4v1636595999196!5m2!1sen!2seg'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
