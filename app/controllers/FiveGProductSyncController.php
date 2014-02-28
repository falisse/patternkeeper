<?php


class FiveGProductSyncController extends \BaseController {
	
	protected $channelproducts;
	protected $stitchLiteSkus;
	private $account;
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//might want to do a check here against account_id's		
		$this->account = Input::get('account_id');
		
		$channels = Account::find($this->account)->channels;
		
		$products = FiveGProduct::with(array('variants'))->where('account_id', $this->account)->get();
		$this->stitchLiteSkus = $this->getSkuMap($products, "variants");
		
		$this->channelproducts = array();
		
		// for each channel grab the respectived products
		foreach($channels as $channel){			
			if($channel->channel == 'vend'){
				$this->getVendProducts($channel);	
			} else {
				// ASSUMPTION: purpose of demo assuming only 2 channels in the world exist
				$this->getShopifyProducts($channel);
			}			
		}
		
		$products = FiveGProduct::with(array('variants'))->where('account_id', $this->account)->get();
				
		// This will return the Master Products from FiveG
		if(isset($this->channelproducts))
		{
			return Response::json(array('status' => 'ok', 'stuff' =>$this->channelproducts));	
		}
	}

	protected function getVendProducts($channel){
		// this should move to a service or helper
				$apiurl = "https://{$channel->shopname}.vendhq.com";
				$apikey = $channel->getApiKey();
				$apipwd = $channel->getPassword();
				
				$vend = new VendAPI\VendAPI($apiurl,$apikey,$apipwd);
				$vendproducts = $vend->getProducts();
				
				$storeVendProducts = $this->saveChannelProducts($vendproducts);
				$vendData = array('vend' => array('lookup' =>$storeVendProducts,'products' => $vendproducts));
				array_push($this->channelproducts, $vendData);				
	}

	protected function getShopifyProducts($channel){
		// this should move to a service or helper
				$apikey = $channel->getApiKey();
				$apipwd = $channel->getPassword();
				
				$apiurl = "https://{$apikey}:{$apipwd}@{$channel->shopname}.myshopify.com/admin/products.json";
				$shopifyproducts = json_decode($this->getcUrlStuff($apiurl), true);
				
				$storeShopifyProducts = $this->saveChannelProducts($shopifyproducts["products"], "variants");
				$shopifyData = array('shopify' => array('lookup' =>$storeShopifyProducts, 'products' => $shopifyproducts["products"]));
				
				//@TODO make sure products exist 
				array_push($this->channelproducts, $shopifyData);				
	}

	private function getcUrlStuff($url, $params = array()){
		// this is NOT the lace for this At All
		$ch = curl_init();

		$opts = array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HTTPGET => 1,
        CURLOPT_POSTFIELDS => null,
        CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_TIMEOUT => 120,
		CURLOPT_FAILONERROR => 1,
		CURLOPT_SSL_VERIFYPEER => FALSE
		);
		
		curl_setopt_array($ch, $opts);

		// Get the response
		$response = curl_exec($ch);
		
		 if ($response === false) {
             return curl_error($ch);
      //      throw new ConnectionErrorException('Unable to connect.');
        }

        $info = curl_getinfo($ch);

        //Remove the "HTTP/1.0 200 Connection established" string
        if (false !== stripos($response, "HTTP/1.0 200 Connection established\r\n\r\n")) {
            $response = str_ireplace("HTTP/1.0 200 Connection established\r\n\r\n", '', $response);
        }
        $result = explode("\r\n\r\n", $response, 2 + $info['redirect_count']);

        $body = array_pop($result);
        $headers = array_pop($result);

		// Close cURL
		curl_close($ch);
		
		// Execute the request & get the response
		return $body;

	}
	
	protected function getSkuMap($prods, $depthkey=NULL){
		$skumap = array();	
		
		if(!is_null($depthkey)){
			for($i=0; $i < count($prods); $i++){
				foreach($prods[$i][$depthkey] as $variant){
					array_push($skumap, $variant["sku"]);
				}
			}
			return $skumap;	
		}
		for($i=0; $i < count($prods); $i++){
			array_push($skumap, $prods[$i]->sku);
		}
		
		return $skumap;
	}
	
	protected function saveChannelProducts($prods, $depthkey=NULL){
			
		if(!is_null($depthkey)){
			for($i=0; $i < count($prods); $i++){
				$productId = $prods[$i]["id"];
				// I'm going to make a large assumption that this is SHOPIFY based on the data structure for brevity
				$channelproductslu = ChannelProductLU::whereRaw("shopify_product_id = ?", array($productId))->get();
				$product_exists = (!$channelproductslu->isEmpty());
				
				
				if(!$product_exists){ // we need to create a product
						$newProduct = FiveGProduct::create(array(
				            'name' => $prods[$i]["title"],
				            'description' => $prods[$i]["body_html"],
				            'account_id' => $this->account
				        ));
					$master_product_id = $newProduct->id;	
				} else {
					$master_product_id = $channelproductslu->first()->product_id;
				
				}
				
				foreach($prods[$i][$depthkey] as $variant){		
					$productvariant = FiveGVariant::firstOrNew(array('sku' => $variant["sku"]));	
					$productvariant->sku = $variant["sku"];
					$productvariant->price = $variant["price"];
					$productvariant->product_id = $master_product_id;
					$productvariant->quantity = $variant["inventory_quantity"];
					$productvariant->attribute1 = $variant["option1"];
					$productvariant->save();
						
						// update the LU table
						$newCPLU = ChannelProductLU::firstOrCreate(array(
							'sku' => $variant["sku"], 
							'product_id' => $master_product_id, 
							'shopify_product_id' => $variant["product_id"]
						)); 
					
				}
			}
		} else {
			for($i=0; $i < count($prods); $i++){
				$productId = $prods[$i]->id;
				// I'm going to make a large assumption that this is VEND based on the data structure for brevity
				$channelproductslu = ChannelProductLU::whereRaw("vend_product_id = ?", array($productId))->get();
				$product_exists = (!$channelproductslu->isEmpty());
				
				if(!$product_exists){ // we need to create a product
						$newProduct = FiveGProduct::create(array(
				            'name' => $prods[$i]->name,
				            'description' => $prods[$i]->description,
				            'account_id' => $this->account
				        ));
					$master_product_id = $newProduct->id;	
				} else {
					$master_product_id = $channelproductslu->first()->product_id;
				
				}
				
					$productvariant = FiveGVariant::firstOrNew(array('sku' => $prods[$i]->sku));	
					$productvariant->sku = $prods[$i]->sku;
					$productvariant->price = $prods[$i]->price;
					$productvariant->product_id = $master_product_id;
					//$productvariant->quantity = $prods[$i]->inventory->count;
					$productvariant->attribute1 = $prods[$i]->variant_option_one_value;
					$productvariant->save();
						
						// update the LU table
						$newCPLU = ChannelProductLU::firstOrCreate(array(
							'sku' => $prods[$i]->sku, 
							'product_id' => $master_product_id, 
							'vend_product_id' => $prods[$i]->id
						)); 
					
				
			}
		}
		return $channelproductslu->toArray();
	}	
}
	
	
	
	