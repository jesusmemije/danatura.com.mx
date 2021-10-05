<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_envios', function (Blueprint $table) {
            $table->id();

            $table->string("nombre",255);
            $table->string("apellidos",255)->nullable();
            $table->string("empresa",255)->nullable();
            $table->string("direccion1",255)->nullable();
            $table->string("direccion2",255)->nullable();
            $table->string("localidad",255)->nullable();
            $table->string("region",255)->nullable();
            $table->string("cp",20)->nullable();
            $table->string("telefono",255)->nullable();
            $table->string("email",255)->nullable();
            $table->string("rfc",255)->nullable();
            $table->string("referencia",255)->nullable();

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
        Schema::dropIfExists('datos_envios');
    }
}
