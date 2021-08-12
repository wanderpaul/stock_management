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
    </head>
    <body class="antialiased">

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
		<label> Sell: </label>
		<select id="prods" name="prods">
			@foreach ($sales as $sale)
			<option value={{$sale->id}}>{{$sale->products}}</option>
			@endforeach
		</select>
		<label> Quantity: </label>
		<input type=text />
		<button type="button">Add</button>
	</div>
    </body>
</html>
