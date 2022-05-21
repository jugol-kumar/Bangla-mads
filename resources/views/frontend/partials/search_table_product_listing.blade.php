
@foreach ($load_more as $key => $product)
    <tr>
        <td width="17%">
            {{  $product->name }} <br>
            <small style="color:#b3b3b3">{{ $product->category->name }}</small>
        </td>
        <td width="10%" class="min_d_none">

        </td>
        <td width="7%" class="min_d_none">{{ home_discounted_base_price($product->id) }}</td>
        <td width="3%">pices</td>
        <td width="8%">
            <div class="product-quantity d-flex align-items-center float-right">
                <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 80px;">
                    <select name="" id="" class="form-control sm_quantity">
                        @php($qty = $product->quantity)
                        @for($i=1; $i<=$qty; $i++ )
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <button type="button"
                        class="btn searchAddToCart bg-main mr-2"
                        @if(Auth::check())
                        onclick="addToCart()"
                        @else
                        onclick="showCheckoutModal()"
                    @endif>
                    <i class="las la-cart-plus"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach
<input class="d-none searchOfferId" value="{{ $load_more->last()->id }}">
<script>
    $(".searchOfferId").data('id', {{ $load_more->last()->id }});
</script>
