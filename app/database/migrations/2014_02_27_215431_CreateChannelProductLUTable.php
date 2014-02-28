<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelProductLUTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
public function up()
	{
		Schema::create('channel_product_lu', function(Blueprint $table)
		{
		  $table->engine = "InnoDB";	
		  $table->increments('id');
	      $table->string('sku')->unique;
		  $table->integer('product_id');
	      $table->string('vend_product_id')->nullable();
	      $table->string('shopify_product_id')->nullable();
		  //$table->string('channel');
		  $table->timestamps();
		  $table->softDeletes();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('channel_product_lu');
	}

}
