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
            $table->string('nome');             
            $table->string('url_original');      
            $table->string('url_marca_dagua');  
            $table->decimal('valor', 8, 2);      
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imgApi');
    }
}
