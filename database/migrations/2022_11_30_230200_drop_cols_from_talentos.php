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
        Schema::table('talentos', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('celular');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talentos', function (Blueprint $table) {
            $table->string('email');
            $table->string('celular')->nullable();
        });
    }
};
