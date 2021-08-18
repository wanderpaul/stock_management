<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class StockController extends Controller
{
	public function index(Request $request)
	{
		$message = "";
		$sub_total = 0;


		if (($request->has('product_id'))) {
			
			if (!$this->isValidValues($request->price, $request->stock)) {
				$message = "Cannot accept negative values";
			} elseif (is_float($request->stock)) {
				$message .= "Can't accept decimal value for stock";
			} else {
				if (!$this->updateSales($request)) {
					$message = "Can't sell stock greater than what we have";
				} else {

					$sub_total = $this->calculate($request);
				}
			}
		}

		if ($request->has('update')) {
			if (!$this->isValidValues($request->update_price, $request->update_stock)) {
				$message = "Cannot accept negative values";
			} elseif (is_float($request->update_stock)) {
				$message .= "Can't accept decimal value for stock";
			} else {
				$this->update($request);
			}
		}
		
		if ($request->has('add_product')) {
			if (!$this->isValidValues($request->price, $request->stock)) {
				$message = "Cannot accept negative values";
			} elseif (is_float($request->stock)) {
				$message .= "Can't accept decimal value for stock";
			} else {
				if ($this->checkProduct($request->product)) {
					$message = "Can't add existing product";
				} else {
					$sale = $this->save($request);
				}
			}
		}

		$sales = $this->showProducts();
		return view('welcome', [
			'sales' => $sales,
			'sub_total' => $sub_total,
			'message' => $message
		]);	
	}

	public function showProducts()
	{
		return DB::table("sales")->get();
	}

	public function updateSales(Request $request)
	{
		$current_sale = DB::table('sales')->where('id', $request->product_id)->first();

		if ($request->stock > $current_sale->stock) {
			return false;
		}
		
		$old_stock = $current_sale->stock;
		$new_stock = $old_stock - $request->stock;
	
		DB::table('sales')->where('id', $request->product_id)->update(['stock'=> $new_stock]);
	}

	public function calculate(Request $request)
	{
		$quantity = $request->stock;
		$sale = DB::table('sales')->where('id', $request->product_id)->first();
		
		$sub_total = $quantity * $sale->price;
		$sub_total += $request->subtotal;

		return $sub_total;
	}

	public function save(Request $request)
	{
		$sale = DB::table('sales')->insert([
			'products' => $request->product,
			'stock' => $request->stock,
			'price' => $request->price
		]);
		return $sale;
	}

	public function update(Request $request)
	{

		$current_sale = DB::table('sales')->where('id', $request->product_id)->first();
		$old_stock = $current_sale->stock;
		$new_stock = $old_stock + $request->update_stock;
		$old_price = $current_sale->price;
		$new_price = $request->update_price ?: $old_price;

		DB::table('sales')->where('id', $request->product_id)->update(['stock'=> $new_stock, 'price' => $new_price]);
	}

	private function isValidValues($price, $stock)
	{
		if ($stock < 0 || $price < 0) {
			return false;
		}

		return true;
	}

	private function checkProduct($product)
	{
		$existing = DB::table('sales')->where('products', $product)->first();
		if (!empty($existing)) {
			return $existing->products;
		}
		return null;
	}
}
