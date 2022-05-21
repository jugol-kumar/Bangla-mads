<div class="side-cart">

    @php

        if($cart = Session::has('cart')) {
            $total =0;
            $cartQty = count($cart = Session::get('cart'));
            if ( $cartQty> 0){
                foreach ($cart as $key => $cartItem) {
                    $total = $total + $cartItem['price'] * $cartItem['quantity'];
                }
                 $data = array('total_price'=>$total, 'total_quantity'=> $cartQty);
            }else{
                $data= 0.00;
            }
        }
    @endphp
    <div class="mini-cart" style="top: 50%;">
            <span class="item-count buttonItemCount">
                {{ $cart ? $cartQty . " Items" : 0 . "Items"}}
            </span>
        <span class="price-count">
            <span class="price">
                <span class="price buttonPrice">
                    {{$cart ? '৳ '. $total : '৳ '. 0.00 }}
                </span>
            </span>
        </span>
    </div>

    <div class="bg-main py-4 px-2 d-flex justify-content-between align-items-center">
        <div class="text-white d-flex align-items-center">
            <i class="la la-shopping-bag fs-24"></i>
            <span class="buttonItemCount"></span>
        </div>
        <div class="">
            <button class="px-3 py-1 border-0 close-sidecart text-main">Close</button>
        </div>
    </div>



    <div class="header-minicart" id="cart_items">
        <a href="" data-target-element="#header-cart"
           class="skip-link skip-cart  no-count">
            <span class="label">Checkout</span>
        </a>

        <div id="header-cart" class="block block-cart skip-content">
            <div id="minicart-error-message" class="minicart-message"></div>
            <div id="minicart-success-message" class="minicart-message"></div>
            <div class="minicart-wrapper">
                <p class="block-subtitle">
                    Recently added item(s) <a class="close skip-link-close" href="#" title="Close">×</a>
                </p>
            </div>
        </div>

        @if(Session::has('cart'))
            @if(count($cart = Session::get('cart')) > 0)
                <div class="p-3 fs-15 fw-600 p-3 border-bottom">
                    {{translate('Cart Items')}}
                </div>
                <ul class="h-sel-20 overflow-auto c-scrollbar-light list-group list-group-flush">
                    @foreach($cart as $key => $cartItem)
                        @php
                            $product = \App\Product::find($cartItem['id']);
                            $total = $total + $cartItem['price']*$cartItem['quantity'];
                        @endphp
                        @if ($product != null)
                            <li class="list-group-item">
                            <span class="d-flex align-items-center">
                                <a href="{{ route('product', $product->slug) }}" class="text-reset d-flex align-items-center flex-grow-1">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        class="img-fit lazyload size-60px rounded"
                                        alt="{{  $product->getTranslation('name')  }}"
                                    >
                                    <span class="minw-0 pl-2 flex-grow-1">
                                        <span class="fw-600 mb-1 text-truncate-2">
                                                {{  $product->getTranslation('name')  }}
                                        </span>
                                        <span class="">{{ $cartItem['quantity'] }}x</span>
                                        <span class="">{{ single_price($cartItem['price']) }}</span>
                                    </span>
                                </a>
                                <span class="">
                                    <button onclick="removeFromCart({{ $key }})" class="btn btn-sm btn-icon stop-propagation">
                                        <i class="la la-close"></i>
                                    </button>
                                </span>
                            </span>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between">
                    <span class="opacity-60">{{translate('Subtotal')}}</span>
                    <span class="fw-600">{{ single_price($total) }}</span>
                </div>
                <div class="px-3 py-2 text-center border-top">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="{{ route('cart') }}" class="btn btn-soft-primary btn-sm">
                                {{translate('View cart')}}
                            </a>
                        </li>
                        @if (Auth::check())
                            <li class="list-inline-item">
                                <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary btn-sm">
                                    {{translate('Checkout')}}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            @else
                <div class="text-center p-3">
                    <i class="las la-frown la-3x opacity-60 mb-3"></i>
                    <h3 class="h6 fw-700">{{translate('Your Cart is empty')}}</h3>
                </div>
            @endif
        @else
            <div class="text-center p-3">
                <i class="las la-frown la-3x opacity-60 mb-3"></i>
                <h3 class="h6 fw-700">{{translate('Your Cart is empty')}}</h3>
            </div>
        @endif
    </div>
</div>
