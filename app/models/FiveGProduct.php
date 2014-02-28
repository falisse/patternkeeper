<?php

class FiveGProduct extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fiveg_product';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	protected $guarded = array('id');
	protected $hidden = array('account_id');
	protected $softDelete = true;

	public function account(){
		return $this->belongsTo('Account', 'account_id');
	}
	
	public function variants(){
		return $this->hasMany('FiveGVariant', 'product_id');
	}

	public function attributes(){
		return $this->hasMany('FiveGAttribute', 'product_id');
	}

	
}