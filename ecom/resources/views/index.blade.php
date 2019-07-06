<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
	<h2>Available Products</h2>

<table>
  <tr>
    <th>Name(id)</th>
    <th>Price</th>
    <th>description</th>
    <th>image</th>
    <th>Quantity</th>
  </tr>

  <form action="/order" method="post">
  			    <input type="hidden" name="_token" value="{{ csrf_token() }}">

  @foreach($products as $product)
    <tr>
    <td>{{$product->title}}({{$product->id}})</td>
    <td>{{$product->price}}</td>
    <td>{{$product->description}}</td>

    <td><img height="100px" width="100px" src="{{$product->image_url}}" ></td>
    <td>

		    <input
		    	type="number"
		    	name="{{$product->id}}" step="any"
		    	min="0"
		    	max="{{$product->quantity}}">(Available: {{$product->quantity}})

    </td>

  </tr>
  @endforeach
  <input type="submit" value="Order Now" height="200px" width="200px" >

</form>

</table>
<br><br><br><br>
<hr>




<br><br>
</body>
</html>
