<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInputInCourseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_translations', function (Blueprint $table) {
            $table->string('lecturer_name')->nullable()->change();
            $table->string('lecturer_speciality')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->text('requirements')->nullable()->change();
            $table->text('advantages')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_translations_', function (Blueprint $table) {
            //
        });
    }
}
