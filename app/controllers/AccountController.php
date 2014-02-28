<?php


class AccountController extends \BaseController {

	/**
	 * Authenticate the user.
	 *
	 * @return Response
	 */
	public function authenticate()
	{
		$credentials = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);
		
		// Not liking this too much  circle back to fix later
		$accountQuery = DB::table('account')->where('email', $credentials['email'])->where('password', $credentials['password'])->first();		
		
		
		if(isset($accountQuery->id))
		{
			$account = Account::with(array('channels'))->findOrFail($accountQuery->id);
			$products = FiveGProduct::with(array('variants', 'attributes'))->where('account_id', $account->getKey())->get();
			return Response::json(array('status' => 'ok', 'account' => $account->toArray(), 'products' => $products->toArray()));	
		}
		
		return Response::json(array('status' => 'error', 'message' => 'Account not found matching your credentials'));
	}

}