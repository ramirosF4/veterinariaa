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
        Schema::table('historial_alimentacions', function (Blueprint $table) {
            $table->string('tipo_alimento')->nullable();
            $table->string('marca_producto')->nullable();
            $table->string('cantidad_porcion')->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_alimentacions', function (Blueprint $table) {
            $table->dropColumn(['tipo_alimento', 'marca_producto', 'cantidad_porcion', 'observaciones']);
        });
    }
};
