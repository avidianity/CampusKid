<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table
                ->string('preliminaries')
                ->nullable()
                ->default(null);
            $table
                ->string('midterms')
                ->nullable()
                ->default(null);
            $table
                ->string('finals')
                ->nullable()
                ->default(null);
            $table->foreignId('student_id');
            $table->foreignId('classroom_id');
            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students');
            $table
                ->foreign('classroom_id')
                ->references('id')
                ->on('classrooms');
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
        Schema::dropIfExists('grades');
    }
}
