
<div class="col-xl-12">
    <div class="row mb-3">
        <div class="col border-main-1 px-0 main_search_bar">
            <ul CLASS="list-unstyled justify-content-between search_button_list mb-0">
                <li><a href="{{ route('search',[ 'q'=> 'a']) }}">A</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'b']) }}">B</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'c']) }}">C</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'd']) }}">D</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'e']) }}">E</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'f']) }}">F</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'g']) }}">G</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'h']) }}">H</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'i']) }}">I</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'j']) }}">J</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'k']) }}">K</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'l']) }}">L</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'm']) }}">M</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'n']) }}">N</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'o']) }}">O</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'p']) }}">P</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'q']) }}">Q</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'r']) }}">R</a></li>
                <li><a href="{{ route('search',[ 'q'=> 's']) }}">S</a></li>
                <li><a href="{{ route('search',[ 'q'=> 't']) }}">T</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'u']) }}">U</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'v']) }}">V</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'w']) }}">W</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'x']) }}">X</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'y']) }}">Y</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'z']) }}">Z</a></li>
                <li><a href="{{ route('search',[ 'q'=> 'all']) }}">ALL</a></li>
            </ul>
        </div>
    </div>
    @if($products->count() > 0)
        <div class="row">
            <table class="col-12 search_product_list table bg-white">
                <thead>
                <tr>
                    <th width="17%">NAME</th>
                    <th width="10%" class="min_d_none">MANUFACTURER</th>
                    <th width="5%" class="min_d_none">PACK SIZE</th>
                    <th width="3%">MRP</th>
                    <th width="10%">CART</th>
                </tr>
                </thead>
                <tbody id="post_data">
                @foreach ($products as $key => $product)
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
                </tbody>
            </table>

        </div>

        <div class="text-center mt-4">
            @if($products->total() > 12)
                <button class="btn LoadMore bg-main text-white searchOfferId"
                        id="loadMore"
                        type="button"
                        data-id="{{ $products->last()->id }}">Load More Product</button>
            @endif
        </div>
    @else
        <h2 class="d-flex align-items-center justify-content-center h-300px w-100">No Product Found</h2>
    @endif
</div>
