<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre','255');
            $table->string('sabor','100')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('gramos','100')->nullable();
            $table->float('precio', 8, 2)->nullable();

            $table->bigInteger('categoria')->nullable();


            $table->string('fotografia','255')->nullable();

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
        Schema::dropIfExists('productos');
    }
}
