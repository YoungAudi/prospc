<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('observaciones')->nullable();
            $table->string('tipo_show')->nullable(); // nuevo
            $table->string('duracion')->nullable(); // nuevo
            $table->decimal('viaticos'); // nuevo
            $table->string('archivo'); // pdf generado
            $table->date('fecha_valido'); // nuevo
            $table->enum('estado', ['pendiente', 'enviada', 'aceptada', 'rechazada'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('propuestas', function (Blueprint $table) {
            $table->dropForeign(['evento_id']);
        });
        Schema::dropIfExists('propuestas');
    }
};
