
<br>

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

@foreach($orders as $order)




	<br>

	<h2>Order ID: {{$order->id}}</h2>

<table>
  <tr>
    <th>Name(id)</th>
    <th>Price</th>
    <th>description</th>
    <th>image</th>
    <th>Quantity</th>
  </tr>

  @php
  	$values = (new \App\Http\Controllers\AccountController)->getSpecificProductsListRequest($order->products);

    foreach($values as $value){
    echo "<tr>";

    echo "<td>".$value->title."</td>";
    echo "<td>".$value->price."</td>";
    echo "<td>".$value->description."</td>";
    echo "<td>".$value->image_url."</td>";
    echo "<td>".$value->quantity."</td>";


    echo "</tr>";
  }

  @endphp


</table>
<br><br><br><br>

<hr>
@endforeach




<br><br>
</body>
</html>
