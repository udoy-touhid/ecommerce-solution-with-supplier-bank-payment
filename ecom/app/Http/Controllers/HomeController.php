<?php

namespace App\Http\Controllers;

class HomeController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function home() {
		return redirect('/');
	}

	public function index() {

		$products = $this->getProductsListRequest();
		return view('index')->with('products', json_decode($products));
	}

	private function getProductsListRequest() {

		$supplier_url = env('SUPPLIER_URL') . '/api/v1/products';

		$client = new \GuzzleHttp\Client();

		$request = $client->get(
			$supplier_url
		);

		$response = $request->getBody();

		return $response;
	}

}
