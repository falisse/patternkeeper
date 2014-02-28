<?php

class AccountTableSeeder extends DatabaseSeeder {
    public function run(){
    	/**$faker = $this->getFaker();
		
		for($i=0; $i < 5; $i++){
			$email = $faker->email;
			$password = Hash::make('password');
			$shopname = $faker->word;
			
			Account::create(array(
				'email'=> $email, 
				'password'=> $password, 
				'shopname' => $shopname
			));
		}**/
		
		Account::create(array(
				'email'=> 'tester@test.com', 
				'password'=> 'test123' 
				//'shopname' => 'fivegees'
		));
		
		Account::create(array(
				'email'=> 'falisse@test.com', 
				'password'=> 'test123' // hash this of course
				//'shopname' => 'fivegees'
		));
		
    }
}