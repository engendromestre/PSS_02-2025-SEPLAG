<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot Table between unidades and enderecos
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unidade_enderecos', function (Blueprint $table) {
            $table->unsignedBigInteger('unid_id');
            $table->unsignedBigInteger('end_id');
            $table->timestamps();

            // Definição da chave primária composta
            $table->primary(['unid_id', 'end_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidade_enderecos');
    }
};
