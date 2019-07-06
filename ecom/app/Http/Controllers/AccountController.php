<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index(Request $request) {

		$products = $request->input('products');
		$quantity = $request->input('quantity');

		if ($products != null && $quantity != null) {
			$order = new \App\Order();
			$order->user_id = Auth::id();
			$order->products = $products;
			$order->quantity = $quantity;
			$order->save();
		}

		$orders = \App\Order::all();

		//return $detail_productList = json_decode($this->getSpecificProductsListRequest($products));

		return view('account.index')->with('orders', $orders);
	}

	public function order(Request $request) {

		$products = json_decode($this->getProductsListRequest());

		$separator = false;
		$list_products = "";
		$list_quantities = "";
		$total_expense = 0;
		foreach ($products as $product) {

			$quantity = $request->input($product->id);

			if ($quantity != null) {

				$total_expense += $quantity * $product->price;
				if ($separator) {
					$list_products .= ";;";
					$list_quantities .= ";;";

				}
				$separator = true;
				$list_products .= $product->id;
				$list_quantities .= $quantity;
			}
		}

		// 1;;5;;4
		$user_account = \App\UserAccount::find(Auth::id());

		if ($user_account == null) {

			return 'no user account info';

		}

		$result = $this->postPaymentUserRequest($user_account, $total_expense);

		if ($result == 'Successful') {
			echo 'User Paid to Daraz, Now Daraz will be paying to supplier<br>';
			sleep(3);

			$result2 = $this->postPaymentSupplierRequest($total_expense, $list_products, $list_quantities);

			if ($result2 == 'Successful') {
				echo 'Daraz Paid to Ali Baba<br>';
				sleep(3);
				return redirect('/account?products=' . $list_products .
					'&' . 'quantity=' . $list_quantities);

			}

		}

		//not successful
		return $result . "(last)" . $result2;

	}

	private function postPaymentSupplierRequest($total_expense, $list_products, $list_quantities) {

		$bank_url = env('SUPPLIER_URL') . 'api/v1/purchase';

		$profit_of_ecom = 0;

		$account_from = env('ECOM_BANK_ACCOUNT');
		$secret = env('ECOM_BANK_SECRET');
		$account_to = env('SUPPLIER_BANK_ACCOUNT');
		$amount_to_send = $total_expense - $profit_of_ecom;

		$client = new \GuzzleHttp\Client();

		$request = $client->post(
			$bank_url,
			array(
				'form_params' => array(
					'account_from' => $account_from,
					'secret' => $secret,
					'account_to' => $account_to,
					'amount_to_send' => $amount_to_send,
					'products' => $list_products,
					'quantity' => $list_quantities,
				),
			)
		);
		//echo "postPaymentSupplierRequest<br>" . $request . "<br>";
		$response = $request->getBody();

		return $response;
	}

	private function postPaymentUserRequest($user_account, $total_expense) {

		$bank_url = env('BANK_URL') . 'api/v1/make_payment';

		$account_from = $user_account->card_no;
		$secret = $user_account->secret;
		$account_to = env('ECOM_BANK_ACCOUNT');
		$amount_to_send = $total_expense;

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

	private function getProductsListRequest() {

		$supplier_url = env('SUPPLIER_URL') . '/api/v1/products';

		$client = new \GuzzleHttp\Client();

		$request = $client->get(
			$supplier_url
		);

		$response = $request->getBody();

		return $response;
	}

	public function getSpecificProductsListRequest($prductsList) {

		$supplier_url = env('SUPPLIER_URL') . '/api/v1/productListDetails?products=' . $prductsList;

		$client = new \GuzzleHttp\Client();

		$request = $client->get(
			$supplier_url
		);

		$response = $request->getBody();

		return json_decode($response);
	}
}
