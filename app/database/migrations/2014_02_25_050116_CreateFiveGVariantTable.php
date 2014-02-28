<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiveGVariantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fiveg_variant', function(Blueprint $table)
		{
		  $table->engine = "InnoDB";	
		  $table->increments('id');
	      $table->integer('product_id');
	      $table->string('sku')->unique();
	      $table->float('price');
		  $table->integer('quantity')->default(0);
		  $table->string('attribute1')->nullable();
		  $table->string('attribute2')->nullable();
		  $table->string('attribute3')->nullable();
		  $table->timestamps();
		  $table->softDeletes();
		  //$table->primary('sku');
		  //$table->foreign('product_id')->references('id')->on('fiveg_product');
		  
		  // for brevity I may limit attributes to 3 argh!
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fiveg_variant');
	}

}
