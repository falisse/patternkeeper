<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiveGVariantAttributeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fiveg_variantattribute', function(Blueprint $table)
		{
		  $table->engine = "InnoDB";
		  //$table->increments('id');
	      $table->integer('attributeid');
	      $table->integer('variantid');
		  $table->string('value');
		  $table->integer('attributeidx');
		  $table->timestamps();
		  $table->softDeletes();
		  $table->primary(array('variantid', 'attributeid'));				
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fiveg_variantattribute');
	}

}
