<?php

class FiveGProductController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$credentials = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);
		
		$product_id = Input::get('productid');
		
		// Not liking this too much  circle back to fix later
		$accountQuery = DB::table('account')->where('email', $credentials['email'])->where('password', $credentials['password'])->first();		
		
		
		if(isset($accountQuery->id))
		{
			$account = Account::with(array('channels'))->findOrFail($accountQuery->id);
			$query = FiveGProduct::with(array('variants', 'attributes'))->where('account_id', $account->getKey());
			
			if($product_id){
				$query->where('id', $product_id);
			}
			
			$products = $query->get();
			
			return Response::json(array('status' => 'ok', 'account' => $account->toArray(), 'products' => $products->toArray()));	
		}
		
		return Response::json(array('status' => 'error', 'message' => 'Account not found matching your credentials'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 * 
	 * @return Response
	 */
	public function store()
	{
		$product = FiveGProduct::create(array(
            'name' => Input::get('name'),
            'description' => Input::get('description'),
			'account_id' => Input::get('accountid')
        ));
		
		$variant = new FiveGVariant(array(
			'sku'=> Input::get('sku'), 
			'product_id'=> $product->id,
			'price'=> Input::get('price'), 
			'quantity'=> Input::get('quantity'), 
			'attribute1' => Input::get('attribute1'),
			'attribute2' => Input::get('attribute2') ,
			'attribute3' => Input::get('attribute3')  // not what I want to do should be id to k => v
		));
		
		$variant = $product->variants()->save($variant);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	private function getAccountInfo($email, $pwd){
		
	}
}