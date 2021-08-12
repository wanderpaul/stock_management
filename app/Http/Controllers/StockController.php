<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class StockController extends Controller
{
	public function index()
	{

	}

	public function showProducts()
	{
		$sales = DB::table("sales")->get();
		return view('welcome', [
			'sales' => $sales
		]);	
	}

	public function calculate()
	{
		
	}
}
