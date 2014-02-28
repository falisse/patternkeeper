<?php

class FiveGVariantTableSeeder extends DatabaseSeeder {
	
	public function run(){
   	//$faker = $this->getFaker();
			
			//$attributes = FiveGAttribute::all()->toArray();
			$products = FiveGProduct::all();
			
			foreach($products as $product)
			{
				if($product->id == 2){
					FiveGVariant::create(array(
						    'sku'=> 'B5378', 
							'product_id'=> $product->id,
							'price'=> 15.00, 
							'quantity'=> 1 // not what I want to do should be id to k => v
						));					
				}
						FiveGVariant::create(array(
							'sku'=> str_shuffle($product->name), 
							'product_id'=> $product->id,
							'price'=> 25.00, 
							'quantity'=> 1, 
							'attribute1' => '12'
						));
						
							
			}
	    } 
	}