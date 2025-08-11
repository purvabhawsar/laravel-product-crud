@extends('layouts.app')

@section('content')
<h1>Products</h1>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Images</th>
        <th>Actions</th>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }}</td>
        <td>
            @foreach($product->images as $img)
                <img src="{{ asset('storage/'.$img->image_path) }}" width="50">
            @endforeach
        </td>
        <td>
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>

        </td>
    </tr>
    @endforeach
</table>
@endsection
