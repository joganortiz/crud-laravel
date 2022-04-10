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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_cliente');
            $table->string("nombre", 55);
            $table->string("imagen", 250)->nullable();
            $table->enum('tipo_servicio', ['1', '0'])->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
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
        Schema::dropIfExists('servicios');
    }
};
