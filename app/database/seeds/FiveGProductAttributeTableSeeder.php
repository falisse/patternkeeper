<?php

class FiveGProductAttributeTableSeeder extends DatabaseSeeder {
    public function run(){
    	
		$products = FiveGProduct::all();
		
		foreach($products as $product)
		{
				
				FiveGAttribute::create(array(
					'name'=> 'size', 
					'value' => '14',
					'attibuteidx'=> 1,
					'product_id'=> $product->id
				));
			
		}
    }
}