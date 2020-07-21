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
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id')->index();
            $table->foreign('role_id')
                ->references('id')->on('users_roles')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->unsignedBigInteger('detail_id')->nullable();
            $table->foreign('detail_id')
                ->references('id')->on('users_detail')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->unsignedBigInteger('data_id')->nullable();
            $table->foreign('data_id')
                ->references('id')->on('users_data')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->unsignedBigInteger('configuration_id')->nullable();
            $table->foreign('configuration_id')
                ->references('id')->on('users_configuration')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('name');
            $table->string('nick')->index()->unique();
            $table->string('email')->index()->unique();
            $table->string('avatar', 511)->default('images/users/profile-avatars/default.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken()->default(null)->nullable();
            //$table->boolean('locked')->default(null)->nullable();
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
        Schema::dropIfExists('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['detail_id']);
            $table->dropForeign(['data_id']);
            $table->dropForeign(['configuration_id']);
        });
    }
}
