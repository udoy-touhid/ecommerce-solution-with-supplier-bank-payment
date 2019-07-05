<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller {
	//
	public function products_V1() {
		$products = \App\Product::all();

		return $products;
	}

	public function sellProducts(Request $request) {

		//get payment
		$bank_url = env('BANK_URL') . 'api/v1/make_payment';
		$response = $this->postGuzzleRequest($bank_url);

		//update bank balance

		//update product quantity

	}

	public function postGuzzleRequest($bank_url) {

		$client = new \GuzzleHttp\Client();

		$request = $client->post(
			$bank_url,
			array(
				'form_params' => array(

				),
			)
		);
		$response = $request->getBody();

		return $response;
	}
}
