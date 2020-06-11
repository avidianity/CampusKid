<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table
                ->text('description')
                ->nullable()
                ->default(null);
            $table->string('token', 7);
            $table
                ->foreignId('profile_picture_id')
                ->nullable()
                ->default(null);
            $table
                ->foreignId('cover_photo_id')
                ->nullable()
                ->default(null);
            $table->foreignId('subject_id');
            $table->foreignId('faculty_id');
            $table->foreignId('department_id');
            $table
                ->foreign('profile_picture_id')
                ->references('id')
                ->on('files');
            $table
                ->foreign('cover_photo_id')
                ->references('id')
                ->on('files');
            $table
                ->foreign('subject_id')
                ->references('id')
                ->on('subjects');
            $table
                ->foreign('faculty_id')
                ->references('id')
                ->on('faculties');
            $table
                ->foreign('department_id')
                ->references('id')
                ->on('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
