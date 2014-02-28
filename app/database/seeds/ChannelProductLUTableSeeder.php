<?php

class ChannelProductLUTableSeeder extends DatabaseSeeder {
    public function run(){
    	
        ChannelProductLU::create(array(
            'sku' => 'B5378',
            'product_id' => 2,
            'shopify_product_id' => '248240781', 
            'vend_product_id' => 'df0900c3-9da2-11e3-a0f5-b8ca3a64f8f4'
        ));
    }
}