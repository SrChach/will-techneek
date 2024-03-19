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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idMateria');
            $table->foreign('idMateria')->references('id')->on('materias')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idTemario');
            $table->foreign('idTemario')->references('id')->on('temas')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idEstadoPago');
            $table->foreign('idEstadoPago')->references('id')->on('estados_pagos')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idAlumno');
            $table->foreign('idAlumno')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('numero_horas');
            $table->float('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
