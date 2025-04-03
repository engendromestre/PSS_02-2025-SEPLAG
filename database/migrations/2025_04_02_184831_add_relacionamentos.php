<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('foto_pessoas', function (Blueprint $table) {
            if (Schema::hasColumn('foto_pessoas', 'pes_id')) {
                $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('restrict');
            }
        });

        Schema::table('enderecos', function (Blueprint $table) {
            if (Schema::hasColumn('enderecos', 'cid_id')) {
                $table->foreign('cid_id')->references('cid_id')->on('cidades')->onDelete('restrict');
            }
        });

        Schema::table('pessoa_enderecos', function (Blueprint $table) {
            if (Schema::hasColumn('pessoa_enderecos', 'pes_id') && Schema::hasColumn('pessoa_enderecos', 'end_id')) {
                $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('restrict');
                $table->foreign('end_id')->references('end_id')->on('enderecos')->onDelete('restrict');
            }
        });

        Schema::table('servidores_temporarios', function (Blueprint $table) {
            if (Schema::hasColumn('servidores_temporarios', 'pes_id')) {
                $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('restrict');
            }
        });

        Schema::table('servidores_efetivos', function (Blueprint $table) {
            if (Schema::hasColumn('servidores_efetivos', 'pes_id')) {
                $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('restrict');
            }
        });

        Schema::table('lotacoes', function (Blueprint $table) {
            if (Schema::hasColumn('lotacoes', 'pes_id') && Schema::hasColumn('lotacoes', 'unid_id')) {
                $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('restrict');
                $table->foreign('unid_id')->references('unid_id')->on('unidades')->onDelete('restrict');
            }
        });

        Schema::table('unidade_enderecos', function (Blueprint $table) {
            if (Schema::hasColumn('unidade_enderecos', 'unid_id') && Schema::hasColumn('unidade_enderecos', 'end_id')) {
                $table->foreign('unid_id')->references('unid_id')->on('unidades')->onDelete('restrict');
                $table->foreign('end_id')->references('end_id')->on('enderecos')->onDelete('restrict');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foto_pessoas', function (Blueprint $table) {
            if (Schema::hasColumn('foto_pessoas', 'pes_id')) {
                $table->dropForeign(['pes_id']);
            }
        });

        Schema::table('enderecos', function (Blueprint $table) {
            if (Schema::hasColumn('enderecos', 'cid_id')) {
                $table->dropForeign(['cid_id']);
            }
        });

        Schema::table('pessoa_enderecos', function (Blueprint $table) {
            if (Schema::hasColumn('foto_pessoas', 'pes_id') && Schema::hasColumn('foto_pessoas', 'end_id')) {
                $table->dropForeign(['pes_id']);
                $table->dropForeign(['end_id']);
            }
        });

        Schema::table('servidores_temporarios', function (Blueprint $table) {
            if (Schema::hasColumn('servidores_temporarios', 'pes_id')) {
                $table->dropForeign(['pes_id']);
            }
        });

        Schema::table('servidores_efetivos', function (Blueprint $table) {
            if (Schema::hasColumn('servidores_efetivos', 'pes_id')) {
                $table->dropForeign(['pes_id']);
            }
        });

        Schema::table('lotacoes', function (Blueprint $table) {
            if (Schema::hasColumn('lotacaos', 'pes_id') && Schema::hasColumn('lotacaos', 'unid_id')) {
                $table->dropForeign(['pes_id']);
                $table->dropForeign(['unid_id']);
            }
        });

        Schema::table('unidade_enderecos', function (Blueprint $table) {
            if (Schema::hasColumn('unidade_enderecos', 'end_id') && Schema::hasColumn('unidade_enderecos', 'unid_id')) {
                $table->dropForeign(['end_id']);
                $table->dropForeign(['unid_id']);
            }
        });
    }
};
