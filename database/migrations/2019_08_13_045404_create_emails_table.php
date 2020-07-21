<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 511);
            $table->string('phone', 255)->nullable();
            $table->string('subject', 511);
            $table->text('message');
            $table->boolean('privacity')->default(0);
            $table->boolean('contactme')->default(0)->nullable();
            $table->decimal('recaptcha_score', 2, 1);
            $table->string('server_ip', 255)->nullable();
            $table->string('client_ip', 255)->nullable();
            $table->string('app_name', 511)->nullable();
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
        Schema::dropIfExists('emails');
    }
}
