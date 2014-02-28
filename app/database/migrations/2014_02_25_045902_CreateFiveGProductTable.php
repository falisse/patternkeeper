<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiveGProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fiveg_product', function(Blueprint $table)
		{
		  $table->engine = "InnoDB";
		  $table->increments('id');
	      $table->string('name');
	      $table->string('description')->nullable();
		  $table->boolean('hasvariants');
		  $table->integer('account_id');
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
		Schema::dropIfExists('fiveg_product');
	}

}
