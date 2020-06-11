<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('provider_id')->unique();
            $table->string('provider_type');
            $table->string('email')->unique();
            $table
                ->foreignId('role_id')
                ->nullable()
                ->default(null);
            $table
                ->string('role_type')
                ->nullable()
                ->default(null);
            $table
                ->string('username')
                ->unique()
                ->nullable()
                ->default(null);
            $table
                ->string('password')
                ->nullable()
                ->default(null);
            $table->enum('access_level', [1, 2, 3])->default(1);
            $table
                ->foreignId('profile_picture_id')
                ->nullable()
                ->default(null);
            $table
                ->foreignId('cover_photo_id')
                ->nullable()
                ->default(null);
            $table
                ->foreign('profile_picture_id')
                ->references('id')
                ->on('files');
            $table
                ->foreign('cover_photo_id')
                ->references('id')
                ->on('files');
            $table
                ->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
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
        Schema::dropIfExists('users');
    }
}
