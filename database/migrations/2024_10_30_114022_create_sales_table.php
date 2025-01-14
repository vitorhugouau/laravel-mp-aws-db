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
        $table->foreignId('user_id')->constrained('usuarios')->onDelete('cascade'); 
        $table->string('user_name'); 
        $table->foreignId('product_id')->constrained('imgApi')->onDelete('cascade');
        $table->string('payment_id')->unique();
        $table->string('status');
        $table->decimal('value', 8, 2); 
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
