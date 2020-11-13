<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->string('forget_token')->nullable();
            $table->dateTime('forget_token_expires_at', 0)->nullable();
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('role_id')->nullable();
            $table->unsignedInteger('reference_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->enum('type', ['Admin', 'User'])->default('User');
            $table->rememberToken();
            $table->softDeletes();
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
