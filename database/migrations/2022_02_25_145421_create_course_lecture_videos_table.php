<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseLectureVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_lecture_videos', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->unsignedBigInteger('course_lecture_id')->index();
            $table->foreign('course_lecture_id')->references('id')->on('course_lectures')->onDelete('cascade');
            $table->auditableWithSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_lecture_videos');
    }
}
