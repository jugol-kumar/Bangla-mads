<div class="col mb-4 sm_padding">
    <a href="{{ route('product', ['slug' => $product->name, 'id' => $product->id]) }}" class="text-black">
        <div class="card medicin_card rounded h-100">
            <img
                class="card-img-top lazyload p-2 product_card_image"
                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                data-src="{{ uploaded_asset($product->photo ?? $product->category->icon) }}"
                alt="{{$product->name}}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
            >

            <div class="card-body text-center p-0 m-0">
                <h5 class="m-0 p-0">{{ Str::limit($product->name, 15) }}</h5>
                <p class="m-0 p-0">{{ $product->single_price }}</p>
            </div>
        </div>
    </a>
</div>
