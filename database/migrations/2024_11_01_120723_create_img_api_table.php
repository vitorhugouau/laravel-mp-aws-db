<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgApiTable extends Migration
{
    public function up()
    {
        Schema::create('imgApi', function (Blueprint $table) {
            $table->id();
            $table->string('nome');              // Nome da imagem
            $table->string('url_original');      // URL da imagem original
            $table->string('url_marca_dagua');   // URL da imagem com marca d'água
            $table->decimal('valor', 8, 2);      // Valor da imagem
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imgApi');
    }
}
