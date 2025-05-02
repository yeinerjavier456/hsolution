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
        Schema::table('users', function (Blueprint $table) {
            $table->string('documento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono_personal')->nullable();
            $table->string('tipo_sangre')->nullable();
            $table->string('eps')->nullable();
            $table->string('otra_eps')->nullable();
            $table->string('contacto_emergencia')->nullable();
            $table->string('telefono_contacto_emergencia')->nullable();
            $table->string('foto')->nullable();
            $table->string('ruta_qr')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
