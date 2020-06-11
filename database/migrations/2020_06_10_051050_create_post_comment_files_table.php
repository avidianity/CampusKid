<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comment_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_comment_id');
            $table->foreignId('file_id');
            $table
                ->foreign('post_comment_id')
                ->references('id')
                ->on('post_comments');
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
        Schema::dropIfExists('post_comment_files');
    }
}
