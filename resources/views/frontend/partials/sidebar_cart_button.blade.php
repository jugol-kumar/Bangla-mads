<span class="item-count">
    @if(Session::has('cart'))
        <span class="badge badge-primary badge-inline badge-pill">{{ count(Session::get('cart'))}}</span>
    @else
        <span class="badge badge-primary badge-inline badge-pill">0</span>
    @endif
</span>

@if(Session::has('cart'))
    @if(count($cart = Session::get('cart')) > 0)
        @php
            $grandTotal = 0;
        @endphp
        @foreach($cart as $key => $cartItem)
            @php
                $product = \App\Product::find($cartItem['id']);
                $total = $total + $cartItem['price']*$cartItem['quantity'];
                $grandTotal += $total;
            @endphp
        @endforeach

        <span class="price-count">
            <span class="price">
                <span class="price">৳ {{ $grandTotal  }}</span>
            </span>
        </span>
    @else
        <span class="price-count">
            <span class="price">
                <span class="price">৳{{ 0.00 }}</span>
            </span>
        </span>
    @endif
@endif


