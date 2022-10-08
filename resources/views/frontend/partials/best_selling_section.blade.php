@if (\App\BusinessSetting::where('type', 'best_selling')->first()->value == 1)
    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 rounded">
                <div class="d-flex mb-3 align-items-baseline justify-content-center">
                    <span class="conte pb-3 d-inline-block best_selling_title fw-500 text-main mb-4">{{ translate('Best Selling Option Here') }}</span>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow mt-5"
                     data-items="6"
                     data-xl-items="5"
                     data-lg-items="6"
                     data-md-items="3"
                     data-sm-items="2"
                     data-xs-items="2"
                     data-arrows='true'
                     data-infinite='true'
                     data-autoplay="false"
                    >
                    @foreach ((\App\Models\Medicine::limit(12)->get()) as $key => $product)
                        <div class="carousel-box">
                            <div class="aiz-card-box rounded medicin_card">
                                <div class="position-relative">
                                    <a href="{{ route('product', $product->name) }}" class="d-block">
                                        <img
                                            class="img-fit lazyload mx-auto h-140px h-md-210px p-2"
                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($product->category->icon) }}"
                                            alt="{{  $product->name  }}"
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
                                        <a href="{{ route('product', $product->name) }}" class="d-block text-reset">{{  Str::limit($product->name, 18)  }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
