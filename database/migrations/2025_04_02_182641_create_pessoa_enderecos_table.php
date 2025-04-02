<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot Table between pessoas and enderecos
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pessoa_enderecos', function (Blueprint $table) {
            $table->unsignedBigInteger('pes_id');
            $table->unsignedBigInteger('end_id');
            $table->timestamps();

            $table->primary(['pes_id', 'end_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoa_enderecos');
    }
};
