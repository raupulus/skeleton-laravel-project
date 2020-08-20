<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id - file_type_id - translation_token - size - originalname - path
        Schema::create('files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('file_type_id')
                ->nullable()
                ->comment('FK al tipo de imagen');
            $table->foreign('file_type_id')
                ->references('id')->on('file_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->string('path', 511)->comment('Ruta que tiene la aplicación hacia la imagen, por ejemplo: users/avatar');
            $table->string('name', 511)
                ->comment('Nombre asignado de forma interna en la aplicación, por ejemplo: fg7s97hg98hjsd8gh0d0.jpg');


            // Lo comento porque pueden existir otros archivos sin miniaturas
            // tal vez habría que plantear una columna de tipo, o una tabla

            /*
            $table->integer('thumbnail_size')
                ->default(0)
                ->comment('Tamaño de la miniatura');
            $table->string('thumbnail_name', 511)
                ->comment('Nombre asignado a la miniatura de forma interna en la aplicación, por ejemplo: fg7s97hg98hjsd8gh0d0_thumbnail.jpg');
            */
            $table->string('originalname', 511)
                ->nullable()
                ->comment('Nombre original de la imagen, el nombre que lleva al subirse');
            $table->integer('size')
                ->default(0)
                ->comment('Tamaño de la imagen');
            $table->string('alt', 511);
            $table->string('title', 511);
            $table->boolean('is_private')->default(0)->comment('Indica si es privada la imagen o pertenece al espacio público de la aplicación');
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
        Schema::dropIfExists('files', function (Blueprint $table) {
            $table->dropForeign(['file_type_id']);
        });
    }
}
