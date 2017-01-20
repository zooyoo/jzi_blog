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
            $table->float('curlTime');
            $table->integer('drawNbr');
            $table->dateTime('drawDateTime');
            $table->string('nums');
            $table->integer('num1');
            $table->integer('num2');
            $table->integer('num3');
            $table->integer('num4');
            $table->integer('num5');
            $table->integer('num6');
            $table->integer('num7');
            $table->integer('num8');
            $table->integer('num9');
            $table->integer('num10');
            $table->integer('num11');
            $table->integer('num12');
            $table->integer('num13');
            $table->integer('num14');
            $table->integer('num15');
            $table->integer('num16');
            $table->integer('num17');
            $table->integer('num18');
            $table->integer('num19');
            $table->integer('num20');
            $table->float('bonus');
            $table->dateTime('insertTime');
            $table->text('error');
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
