<?php

class ChannelProductLU extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'channel_product_lu';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	protected $guarded = array('id', 'sku');
	protected $softDelete = true;

	public function variants(){
		return $this->hasMany('FiveGVariant', 'sku');
	}

	public function products(){
		return $this->hasMany('FiveGProduct', 'product_id');
	}

	public function getVendProductId(){
		return $this->vend_product_id;
	}
	
	public function getShopifyProductId(){
		return $this->shopify_product_id;
	}
	
	public function getProductId(){
		return $this->product_id;
	}
	
	public function getSku(){
		return $this->sku;
	}
}