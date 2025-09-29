<div>
    <div class="mb-3">
        {{-- {{$search}} --}}
<br>
        <input type="search" wire:model.lazy='search' class="form-control"  placeholder="Search">
      </div>
    {{-- The Master doesn't talk, he acts. --}}
    <table class="table" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">qty</th>

                <th scope="col">Image</th>
                <th scope="col">Category</th>
                <th scope="col">Selling Price</th>
                <th scope="col">Price</th>
                <th scope="col">Description</th>
                <th scope="col">Short Description</th>
                <th scope="col">Showing</th>
                <th scope="col">Trend</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <?php $x = 1; ?>
        <tbody>
            @foreach ($products as $c)
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
                    <td>{{$c->qty}}</td>
                    <td>
                        <img src={{ asset('storage/' . $c->image) }} class="img" alt="...">
                    </td>
                    <td>{{$c->category->name}}</td>
                    <td>{{$c->selling_price}}</td>
                    <td>{{$c->price}}</td>
                    <td>{{ $c->description }}</td>
                    <td>{{ $c->short_description }}</td>
                    <td>
                        @if ($c->showing == 1)
                            <span class="btn btn-primary"> Showing</span>
                        @else
                            <span class="btn btn-danger"> Not </span>
                        @endif
                    </td>
                    <td>
                        @if ($c->trend == 1)
                            <span class="btn btn-primary"> Trend</span>
                        @else
                            <span class="btn btn-danger"> Not </span>
                        @endif
                    </td>
                    <td>
                       <a href="{{route('product.show',['product'=>$c->id])}}"> <button type="button" class="btn btn-outline-success">view</button></a>
                       <a href="{{route('product.edit',['product'=>$c->id])}}"> <button type="button" class="btn btn-outline-warning">Edit</button></a>
                        @include('admin.layouts.delete2',['date'=>$c->id])

                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    {{ $products->links() }}
</div>
