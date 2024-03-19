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
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPedido');
            $table->foreign('idPedido')->references('id')->on('pedidos')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idProfesor');
            $table->foreign('idProfesor')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idEstados');
            $table->foreign('idEstados')->references('id')->on('estados_clases')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->string('meeets', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
