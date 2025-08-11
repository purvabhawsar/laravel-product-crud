{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Your Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
        <a href="{{ url('/products') }}" class="btn btn-primary">Continue Shopping</a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>
                            @if($item->product->images && count($item->product->images) > 0)
                                <img src="{{ asset('storage/'.$item->product->images[0]) }}" width="60">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>₹{{ $item->product->price }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control me-2" style="width:80px;">
                                <button type="submit" class="btn btn-sm btn-warning">Update</button>
                            </form>
                        </td>
                        <td>₹{{ $item->product->price * $item->quantity }}</td>
                        <td>
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="mt-3">Grand Total: ₹{{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}</h4>
        
        <a href="{{ url('/checkout') }}" class="btn btn-success">Proceed to Checkout</a>
    @endif
</div>
@endsection
