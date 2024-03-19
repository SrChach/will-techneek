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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idClase');
            $table->foreign('idClase')->references('id')->on('clases')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idCalificado');
            $table->foreign('idCalificado')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idCalificador');
            $table->foreign('idCalificador')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('calificacion', 20);
            $table->text('comentarios', 250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
