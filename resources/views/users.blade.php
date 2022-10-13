@extends('layouts.main')

@section('container')
    @foreach ($users as $user)
        <p>-{{ $user->username }}</p>
        <p>-{{ $user->id }}</p>
        @foreach ($user->useraddress as $address)
            <p>Alamat : {{ $address->address }}</p>
        @endforeach
        {{-- <p>-{{ $user->cartitem }}</p> --}}
        @foreach ($user->cartitem as $cart)
            <p>Cart Item {{ $loop->iteration }}</p>
            <p>Nama product: {{ $cart->product->name }}</p>
            <p>Nama product: {{ $cart->product->slug }}</p>
            <p>harga: {{ $cart->product->price }}</p>
            <br>
        @endforeach        
        @foreach ($user->orderitem as $order)
            <p>Order Item {{ $loop->iteration }}</p>
            <p>Nama product: {{ $order->product->name }}</p>
            <p>Nama product: {{ $order->product->slug }}</p>
            <p>harga: {{ $order->product->price }}</p>
            <br>
        @endforeach
        {{-- <p>{{ $user->usermerk->name }}</p>
        <p>{{ $user->promo->id }}</p> --}}
        <br>
    @endforeach
@endsection
