@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>


        <div class="mb-3">
            <label>Existing Images</label>
            <div class="row">
                @foreach($product->images as $image)
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid mb-2" style="max-height: 100px;">
                        <br>
                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"> Remove
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label>Add New Images</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
