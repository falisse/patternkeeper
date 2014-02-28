<?php

class FiveGProductTableSeeder extends DatabaseSeeder {
    public function run(){
    	//$faker = $this->getFaker();

        FiveGProduct::create(array(
            'name' => 'Vogue 3211',
            'description' => 'Vintage slip',
            'account_id' => 2
        ));
        
        FiveGProduct::create(array(
            'name' => 'Butterick 5378',
            'description' => 'The Bias cut away jumper banded and belted',
            'account_id' => 2
        ));
		

    }
}