<?php


class AccountChannel extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'accountchannel';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	protected $guarded = array('id');
	protected $hidden = array('apikey', 'password', 'account_id');
	protected $softDelete = true;

	/**
	 * Get the apikey for the channel.
	 *
	 * @return mixed
	 */
	public function getApiKey()
	{
		return $this->apikey;
	}

	public function getPassword()
	{
		return $this->password;
	}
	
	public function getShopName()
	{
		return $this->shopname;
	}
	
	public function getChannelName()
	{
		return $this->channel;
	}
	
	public function account(){
		return $this->belongsTo('Account', 'account_id');
	}

}