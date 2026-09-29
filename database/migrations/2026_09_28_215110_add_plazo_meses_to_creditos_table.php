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
        Schema::table('creditos', function (Blueprint $table) {
            // Agrega la columna 'plazo_meses' después del campo 'tasa_interes'
            $table->integer('plazo_meses')->after('tasa_interes')->default(12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creditos', function (Blueprint $table) {
            // Elimina la columna si se revierte la migración
            $table->dropColumn('plazo_meses');
        });
    }
};