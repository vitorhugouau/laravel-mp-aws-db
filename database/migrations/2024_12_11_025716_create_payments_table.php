<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique(); // Armazenando o ID do pagamento
            $table->string('external_reference')->nullable(); // Armazenando a referência externa
            $table->string('payer_name')->nullable(); // Nome do pagador
            $table->string('payer_email')->nullable(); // Email do pagador
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status do pagamento
            $table->timestamps(); // Timestamps para created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
