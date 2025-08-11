@extends('layouts.app')

@section('content')
<h1>Add Product</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Product Name:</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" step="0.01" name="price" id="price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">Product Images:</label>
        <input type="file" name="images[]" id="images" class="form-control" multiple>
    </div>

    <button type="submit" class="btn btn-success">Save Product</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
