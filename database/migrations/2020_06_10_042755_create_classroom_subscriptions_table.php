<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_subscriptions', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('classroom_subscriptions');
    }
}
