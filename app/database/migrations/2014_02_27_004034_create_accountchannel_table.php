<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountchannelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accountchannel', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('apikey');
			$table->string('password');
			$table->string('channel');
			$table->string('shopname');
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
		Schema::dropIfExists('accountchannel');
	}

}
