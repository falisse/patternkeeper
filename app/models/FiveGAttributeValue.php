<?php


class FiveGAttributeValue extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fiveg_variantattribute';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	protected $guarded = array('id');
	protected $softDelete = true;

	public function variant(){
		return $this->belongsTo('FiveGVariant');
	}

}