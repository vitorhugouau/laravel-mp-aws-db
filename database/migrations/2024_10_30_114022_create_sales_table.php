<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
{
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('usuarios')->onDelete('cascade'); // Chave estrangeira para 'usuarios'
        $table->string('user_name'); // Nome do usuário
        $table->foreignId('product_id')->constrained('imagens')->onDelete('cascade');
        $table->string('payment_id')->unique();
        $table->string('status');
        $table->decimal('value', 8, 2); // Valor pago
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
