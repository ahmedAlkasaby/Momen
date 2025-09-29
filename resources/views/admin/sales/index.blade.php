@extends('admin.master')
@section('name_of_page')
Sales
@endsection
@section('content')
<div class="container mt-5">
    <center>
        <style>
            button {
                padding: 20px 40px;
                font-size: 18px;
                background-color: #007bff;
                color: #ffffff;
                border: none;
                border-radius: 10px;
                cursor: pointer;
            }
        </style>

    </center>

    <table class="table" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Category</th>
                <th scope="col">Selling Price</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Total Price</th>
                <th scope="col">Gain</th>
                <th scope="col">User</th>
                <th scope="col">User Email</th>


            </tr>
        </thead>
        <?php $x = 1;

        ?>
        <tbody>
            @foreach ($sales as $c)
                @foreach ($products as $p)
                  @if ($p->id==$c->product_id)
                  @php
                      $product=$p
                  @endphp
                  @endif

                @endforeach
                @php
                    $Gain=($c->qty*$product->selling_price)-($c->qty*$product->price);
                @endphp
                <tr>
                    <th scope="row">{{ $x++ }}</th>
                    <td>{{ $c->name }}</td>
                    <style>
                        .img {
                            width: 200px;
                            height: 200px;
                            overflow: hidden;
                            border-radius: 10px;

                        }
                    </style>
                    <td>
                        <img src={{ asset('storage/' . $product->image) }} class="img" alt="...">
                    </td>
                    <td>{{$product->category->name}}</td>
                    <td>{{$product->selling_price}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$c->qty}}</td>
                    <td>{{$c->qty*$product->selling_price}}</td>
                    <td>{{$Gain}}</td>
                    <td>{{$c->user->name}}</td>
                    <td>{{$c->user->email}}</td>
                    <td>
                    <a href="{{route('create_notification',['sale_id'=>$c->id])}}">
                    <button type="button" class="btn btn-primary">Send Email</button>
                     </a>
                    </td>

                </tr>
            @endforeach


        </tbody>
    </table>
</div>

@endsection
