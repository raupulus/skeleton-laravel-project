<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id - type - mime - icon16 - icon32 - icon64 - icon128
        Schema::create('file_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->string('type', 127);
            $table->string('mime', 127)->index();
            $table->string('extension', 12);
            $table->text('icon16')->default('images/icons/file-types/default_16.png');
            $table->text('icon32')->default('images/icons/file-types/default_32.png');
            $table->text('icon64')->default('images/icons/file-types/default_64.png');
            $table->text('icon128')->default('images/icons/file-types/default_128.png');
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
        Schema::dropIfExists('file_types');
    }
}
