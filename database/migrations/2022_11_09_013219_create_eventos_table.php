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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospecto_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->date('fecha');
            $table->enum('tipo', ['publico', 'privado']);
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
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['prospecto_id']);
        });
        Schema::dropIfExists('eventos');
    }
};
