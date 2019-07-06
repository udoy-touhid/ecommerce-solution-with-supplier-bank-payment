<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index() {
		$products = \App\Product::all();

		return view('products.index')->with('products', $products);
	}

	public function add(Request $request) {
		$product = new \App\Product();

		$product->title = $request->input('name');
		$product->description = $request->input('details');
		$product->image_url = $request->input('image_url');
		$product->quantity = $request->input('quantity');

		$product->price = $request->input('price');

		$product->save();

		return redirect('/');
	}

	public function delete(Product $product) {
		$product->delete();

		return redirect('/');
	}
}
