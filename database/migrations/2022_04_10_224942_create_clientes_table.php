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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 55);
            $table->string("imagen", 250)->nullable();
            $table->string("cedula", 20)->nullable();
            $table->string("correo", 55)->nullable();
            $table->string("telefono", 10)->nullable();
            $table->text("observaciones")->nullable();
            $table->enum('eliminado', ['1', '0'])->nullable();
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
        Schema::dropIfExists('clientes');
    }
};
