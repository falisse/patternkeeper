<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiveGProductAttributeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fiveg_productattribute', function(Blueprint $table)
		{
		  $table->engine = "InnoDB";
		  $table->increments('id');
	      $table->integer('product_id');
	      $table->integer('attibuteidx');
	      $table->string('name');
		  $table->string('value');
		  $table->timestamps();
		  $table->softDeletes();
		  //$table->foreign('product_id')->references('id')->on('fiveg_product');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fiveg_productattribute');
	}

}
