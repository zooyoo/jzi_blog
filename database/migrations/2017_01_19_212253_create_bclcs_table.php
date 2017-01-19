<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBclcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bclcs', function (Blueprint $table) {
            $table->increments('id');
            $table->float('FCurlTime');
            $table->integer('FDrawNbr');
            $table->dateTime('FDrawDateTime');
            $table->integer('FNum1');
            $table->integer('FNum2');
            $table->integer('FNum3');
            $table->integer('FNum4');
            $table->integer('FNum5');
            $table->integer('FNum6');
            $table->integer('FNum7');
            $table->integer('FNum8');
            $table->integer('FNum9');
            $table->integer('FNum10');
            $table->integer('FNum11');
            $table->integer('FNum12');
            $table->integer('FNum13');
            $table->integer('FNum14');
            $table->integer('FNum15');
            $table->integer('FNum16');
            $table->integer('FNum17');
            $table->integer('FNum18');
            $table->integer('FNum19');
            $table->integer('FNum20');
            $table->float('FBonus');
            $table->dateTime('FInsertTime');
            $table->text('FError');
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
        Schema::dropIfExists('bclcs');
    }
}
