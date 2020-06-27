<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logins', function (Blueprint $table) {
            $table->id();
            $table->text('user_agent')->nullable();
            $table->ipAddress('ip_address');
            $table->foreignId('user_id');
            $table->foreignId('token_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table
            	->foreign('token_id')
            	->references('id')
            	->on('personal_access_tokens');
            $table->timestamp('date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logins');
    }
}
