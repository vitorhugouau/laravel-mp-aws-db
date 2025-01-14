<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); 
            $table->string('external_reference')->nullable(); 
            $table->string('payer_name')->nullable(); 
            $table->string('payer_email')->nullable(); 
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); 
            $table->timestamps(); 
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('set null'); 
            $table->unsignedBigInteger('imagem_id')->nullable(); 
            $table->foreign('imagem_id')->references('id')->on('imgApi')->onDelete('cascade'); 
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['imagem_id']);
            $table->dropColumn('imagem_id');
        });

        Schema::dropIfExists('payments');
    }
};
