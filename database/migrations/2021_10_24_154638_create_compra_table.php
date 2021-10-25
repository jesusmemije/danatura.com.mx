<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->decimal('preciototal', $precision = 10, $scale = 2);
            $table->string('status',100);
            $table->string('chargeid',255);
            $table->string('method',100);
            $table->bigInteger('id_datosenvio');
            $table->foreign('id_datosenvio')->references('id_datosenvio')->on('datos-envios');
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
        Schema::dropIfExists('compra');
    }
}
