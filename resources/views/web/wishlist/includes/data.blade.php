<tr>
    <td class="text-center">
        <img src="{{ asset($favorite->product->image) }}" alt="card" class="img-fluid img__box"
            style="max-width: 80px;">
    </td>

    <td>
        {{ $favorite->product->nameLang() }} <br>
        {{-- <small class="text-muted">{{ $favorite->product->category->name}}</small> --}}
    </td>

    <td>
        {{ $favorite->product->price }} EGP
    </td>

    <td>
        <button class="button__second__small">{{ __('site.add_to_cart') }}</button>
    </td>

    <td>
        <button type="button" class="btn btn-sm removeFavorite" data-id="{{ $favorite->product->id }}">
            <img src="{{ asset('website/assets/Delete.svg') }}" alt="">
        </button>
    </td>
</tr>
