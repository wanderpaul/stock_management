<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class StockController extends Controller
{
	public function index(Request $request)
	{
		$sub_total = "";
		if (($request->has('product_id'))) {
			$this->updateSales($request);
			$sub_total = $this->calculate($request);
		}

		if ($request->has('update')) {
			$this->update($request);
		}
		
		if ($request->has('add_product')) {
			$sale = $this->save($request);
		}

		$sales = $this->showProducts();
		return view('welcome', [
			'sales' => $sales,
			'sub_total' => $sub_total
		]);	
	}

	public function showProducts()
	{
		return DB::table("sales")->get();
	}

	public function updateSales(Request $request)
	{
		$current_sale = DB::table('sales')->where('id', $request->product_id)->first();
		$old_stock = $current_sale->stock;
		$new_stock = $old_stock - $request->stock;
	
		DB::table('sales')->where('id', $request->product_id)->update(['stock'=> $new_stock]);
	}

	public function calculate(Request $request)
	{
		$quantity = $request->stock;
		$sale = DB::table('sales')->where('id', $request->product_id)->first();
		
		if ($sale->stock <= 0) {
			return -1;
		}

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
}
