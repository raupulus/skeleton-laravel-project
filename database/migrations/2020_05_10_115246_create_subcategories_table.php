<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->bigInteger('category_id')
                ->nullable()
                ->comment('FK a la categoría principal');
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->bigInteger('file_id')
                ->nullable()
                ->comment('FK a la imagen en la tabla files');
            $table->foreign('file_id')
                ->references('id')->on('files')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('name', 511)
                ->unique()
                ->comment('Nombre de la subcategoría');
            $table->string('slug', 255)
                ->unique()
                ->comment('Slug para el URL');
            $table->string('description', 1023)
                ->nullable()
                ->comment('Descripción acerca de lo que contendrá esta subcategoría');
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
        Schema::dropIfExists('subcategories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['file_id']);
        });
    }
}
