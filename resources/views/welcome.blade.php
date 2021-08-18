<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Stock Management</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	<!-- Styles -->
	<style>
	    body {
		font-family: 'Nunito', sans-serif;
	    }
table, th, td {
  border: 1px solid black;
}
	</style>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous">
</script>
    </head>
    <body class="antialiased">
    @if ($message)
    	<label style="color:red">{{ $message }} </label>
	@endif
	<br>
	<br>
	<br>
	<form class="add_form" action="/">
		<label> Add Product </label>
		<br>
		<label> Product </label>
		<input id="product" name="product" type=text />
		<label> Price </label>
		<input id="price" name="price" type=text />
		<label> Stock </label>
		<input id="stock" name="stock" type=text />
		<button id='add_sale' name="add_product" value="1">Add Product</button>
	</form>
	<br>
	<br>
	<br>
	<form class="update_form" action="/">
		<label> UPDATE </label>
		<br>
		<select id="product_id" name="product_id">
			@foreach ($sales as $sale)
			<option value={{$sale->id}}>{{$sale->products}}</option>
			@endforeach
		</select>
		<label> Price </label>
		<input id="update_price" name="update_price" type=text />
		<label> Stock </label>
		<input id="update_stock" name="update_stock" type=text />
		<input type="hidden" name="subtotal" value={{$sub_total}} />
		<button id='add_sale' name="update" value="1">Update</button>
	</form>
	<br>
	<div class="table-products">
		<table style="width:20%">
			<tr>
				<th>Products</th>
				<th>Stocks</th>
				<th>Price</th>
			</tr>
			@foreach ($sales as $sale)
				<tr>
					<td> {{$sale->products}}</td>
					<td> {{$sale->stock}}</td>
					<td> {{$sale->price}}</td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="sell" style="padding-top:50px">
	<form class="sell_form" action="/">
		<label> Sell: </label>
		<select id="product_id" name="product_id">
			@foreach ($sales as $sale)
			<option value={{$sale->id}}>{{$sale->products}}</option>
			@endforeach
		</select>
		<label> Quantity: </label>
		<input id="stock" name="stock" type=text />
		<input type="hidden" id="subtotal" name="subtotal" type=text value={{$sub_total}} />
		<button id='add_sale' name="add_sale" value="1">Add Sale</button>
	</form>
		<label> Total Sale: {{$sub_total}} </label>
	</div>
    </body>
</html>
