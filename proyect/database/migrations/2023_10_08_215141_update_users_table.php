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
            $table->string('apellidos')->after('nombre');
            $table->string('telefono')->after('apellidos');
            $table->string('foto')->after('telefono')->nullable();
            $table->unsignedBigInteger('idRol')->after('id')->default(3);
            $table->foreign('idRol')->references('id')->on('roles')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idStatus')->after('idRol')->default(1);
            $table->foreign('idStatus')->references('id')->on('estados_usuarios')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('idGoogle', 150)->after('idStatus');
            $table->date('nacimiento')->after('telefono');
            $table->string('puntuacion', 20)->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
