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

		$products = $request->input('products');
		$quantity = $request->input('quantity');

		if (!isset($products) || !isset($quantity)) {
			return "Unsuccessful";
		}

		//get payment & update bank balance

		$bank_url = env('BANK_URL') . 'api/v1/make_payment';
		$response = $this->postPaymentRequest($bank_url, $request);

		//update product quantity
		if ($response == "Successful") {

			$this->updateStock($products, $quantity);
			return $response;

		} else {
			return $response;
		}

	}

	private function updateStock($products, $quantity) {
		$var_product = explode(";;", $products);
		$var_quantity = explode(";;", $quantity);

		for ($i = 0; $i < count($var_product); $i++) {

			echo $var_product[$i] . "...." . $var_quantity[$i];
			$this->fixProductQuantity($var_product[$i], $var_quantity[$i]);

		}
	}
	private function fixProductQuantity($arg_product, $quantity) {
		$product = \App\Product::find($arg_product);
		if ($product != null) {
			$product->quantity -= $quantity;
			$product->save();
		}

	}

	private function postPaymentRequest($bank_url, $request) {

		$account_from = $request->input('account_from');
		$secret = $request->input('secret');
		$account_to = $request->input('account_to');
		$amount_to_send = $request->input('amount_to_send');

		$client = new \GuzzleHttp\Client();

		$request = $client->post(
			$bank_url,
			array(
				'form_params' => array(
					'account_from' => $account_from,
					'secret' => $secret,
					'account_to' => $account_to,
					'amount_to_send' => $amount_to_send,
				),
			)
		);
		$response = $request->getBody();

		return $response;
	}

}
