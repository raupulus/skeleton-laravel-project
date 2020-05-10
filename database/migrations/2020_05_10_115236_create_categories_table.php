<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->bigInteger('image_id')
                ->nullable()
                ->comment('FK a la imagen');
            $table->foreign('image_id')
                ->references('id')->on('images')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('name', 511)->comment('Nombre de la categoría');
            $table->string('slug', 255)->comment('Slug para el URL');
            $table->string('description', 1023)
                ->nullable()
                ->comment('Descripción acerca de lo que contendrá esta categoría');
            $table->string('icon', 255)->nullable()->comment('Clase css para el icono');
            $table->string('color', 255)
                ->default('#000000')
                ->comment('Código Hexadecimal del color');
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
        Schema::dropIfExists('categories', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });
    }
}
