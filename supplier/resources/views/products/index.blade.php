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
<table>
  <tr>
    <th>Name</th>
    <th>description</th>
    <th>image</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>delete</th>
  </tr>

  @foreach($products as $product)
    <tr>
    <td>{{$product->title}}</td>
    <td>{{$product->description}}</td>

    <td><img height="100px" width="100px" src="{{$product->image_url}}" ></td>
    <td>{{$product->quantity}}</td>

    <td>{{$product->price}}</td>
    <td><a href="/products/{{$product->id}}/delete">delete</a> </td>

  </tr>
  @endforeach

</table>
<br><br><br><br>
<hr>
<h2>Add New Product</h2>

 <form action="/products/add" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <label for="fname">Name</label><br>
    <input required type="text" name="name" placeholder="Name"><br>

    <label for="lname">Details</label><br>
    <input required type="text"  name="details" placeholder="Details"><br>

    <label for="lname">Image URL</label><br>
    <input required type="text" placeholder="url" name="image_url"><br>

    <label for="lname">Quantity</label><br>
    <input required type="number"   step="any" min="0"   name="quantity" placeholder="like: 20"><br>


    <label for="lname">Price</label><br>
    <input required type="number"   step="any" min="0"   name="price" placeholder="like: 20"><br>

    <input type="submit" value="Submit">
  </form>


<br><br>
</body>
</html>
