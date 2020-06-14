<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table
                ->text('remarks')
                ->nullable()
                ->default(null);
            $table->foreignId('task_id');
            $table->foreignId('student_id');
            $table
                ->foreign('task_id')
                ->references('id')
                ->on('tasks');
            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students');
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
        Schema::dropIfExists('task_submissions');
    }
}
