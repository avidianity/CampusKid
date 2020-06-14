<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSubmissionFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_submission_id');
            $table->foreignId('file_id');
            $table
                ->foreign('task_submission_id')
                ->references('id')
                ->on('task_submissions');
            $table
                ->foreign('file_id')
                ->references('id')
                ->on('files');
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
        Schema::dropIfExists('task_submission_files');
    }
}
