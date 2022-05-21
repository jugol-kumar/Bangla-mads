<input class="d-none searchOfferId" value="{{ $load_more->last()->id }}">
@foreach ($load_more as $key => $product)
    <div class="col-md-3 mb-3 product_card_padding">
        <div class="carousel-box single_product_card">
            <div class="aiz-card-box rounded border-radius-5">
                <div class="position-relative">
                    <a href="{{ route('product', $product->slug) }}" class="d-block">
                        <img
                            class="img-fit lazyload mx-auto h-140px h-md-130px px-10px pt-10px"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                            alt="{{  $product->getTranslation('name')  }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        >
                    </a>
                    <div class="absolute-top-right aiz-p-hov-icon">
                        <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                            <i class="la la-heart-o"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                            <i class="las la-sync"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                            <i class="las la-shopping-cart"></i>
                        </a>
                    </div>
                </div>
                <div class="py-md-3 p-1 py-2 p-md-1 text-center">
                    <h3 class="fw-600 fs-15 text-truncate-2 lh-1-4 mb-0 h-35px">
                        <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  Str::limit($product->getTranslation('name'), 10)."|". $product->id  }}</a>
                    </h3>

                    <div class="fs-16 mx-5 d-flex align-items-center justify-content-center">
                        <span class="fw-700 text-black">{{ home_discounted_base_price($product->id) }}</span>
                    </div>

                    @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                        <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                            {{ translate('Club Point') }}:
                            <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
<script>
    $(".searchOfferId").data('id', {{ $load_more->last()->id }});
</script>
