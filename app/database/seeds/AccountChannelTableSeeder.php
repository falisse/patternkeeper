<?php

class AccountChannelTableSeeder extends DatabaseSeeder {
    public function run(){

		AccountChannel::create(array(
				'apikey'=> 'b99dd0ff1160f2700c13b1f490107640', 
				'password'=> '69f2d041c17a756785f5ca1aea14ea33', 
				'shopname' => 'fivegees',
				'channel' => 'shopify',
				'account_id' => 2
		));
		
		AccountChannel::create(array(
				'apikey'=> 'falisse@gmail.com', 
				'password'=> 'test123', // may need to change back to previous if this doesn't work
				'shopname' => 'fivegees',
				'channel' => 'vend',
				'account_id' => 2
		));
		
    }
}