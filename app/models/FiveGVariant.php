<?php


class FiveGVariant extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fiveg_variant';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	protected $guarded = array('id');
	protected $softDelete = true;

	public function product(){
		return $this->belongsTo('FiveGProduct');
	}
	
}