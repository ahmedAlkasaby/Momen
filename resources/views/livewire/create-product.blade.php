<div>
    @if ($message)
    <div class="alert alert-success" role="alert">
        <button type="button" wire:click='close_message' class="btn btn-danger">X</button>  {{$message}}
      </div>
    @endif
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="container mt-5">
        <form wire:submit.prevent='save' >
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name Product</label>
                <input type="text" wire:model='name' class="form-control" id="exampleFormControlInput1" placeholder="Name Of product"
                    name="name">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Qty</label>
                <input type="number" wire:model='qty' class="form-control" id="exampleFormControlInput1"
                    name="qty">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Price</label>
                <input type="text" wire:model='price' class="form-control" id="exampleFormControlInput1" placeholder="Name Of Category"
                    name="price">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Selling Price</label>
                <input type="text" wire:model='selling_price' class="form-control" id="exampleFormControlInput1" placeholder="Name Of Category"
                    name="selling_price">
            </div>
            @if ($img_path)
            <div class="text-center">
                <img src="{{asset('storage/'.$img_path)}}" class="rounded" alt="...">
              </div>
            @endif
            <div>
                <label for="formFileLg" class="form-label">Image</label>
                <input  class="form-control form-control-lg" id="formFileLg" type="file" wire:model='image' >
            </div>
            <label class="form-label">Category</label>
            <select class="form-select" aria-label="Default select example" wire:model='category_id'  name="category_id">
                @foreach ($categories as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                @endforeach
            </select>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" wire:model='description'></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_description" wire:model='short_description'></textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="showing" wire:model='showing'>
                <label class="form-check-label" for="flexCheckDefault">
                    Showing
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="trend" wire:model='trend'>
                <label class="form-check-label" for="flexCheckChecked">
                    Trend
                </label>
            </div>
            <br>
            <input type="submit" value="Submit" class="btn btn-primary">
            <br>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </form> <!-- Create Post Form -->
    </div>
</div>
