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
            $table->string('phone', 255);
            $table->string('subject', 511);
            $table->text('message');
            $table->boolean('privacity');
            $table->boolean('contactme');
            $table->decimal('recaptcha_score', 2, 1);
            $table->string('server_ip', 255);
            $table->string('client_ip', 255);
            $table->string('app_name', 511);
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
        Schema::dropIfExists('emails');
    }
}
