<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseLectureVideoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_lecture_video_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('course_lecture_video_id');
            $table->string('locale')->index();
            $table->unique(['course_lecture_video_id', 'locale'] , 'lecture_video_locale_index');
            $table->foreign('course_lecture_video_id' , 'lecture_video_translation')->references('id')->on('course_lecture_videos')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_lecture_video_translations');
    }
}
