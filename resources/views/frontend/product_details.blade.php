@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency" content="{{ \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white rounded p-3">
                <div class="row">
                    <div class="col-md-3 d-none d-md-block">
                        @include('frontend.partials.left_category')
                    </div>
                    <div class="col-md-9">
                        <div class="bg-main p-3 fs-19 fw-600 text-white">
                            {{ $detailedProduct->getTranslation('name') }}
                        </div>

                        <div class="row mt-4">
                            <div class="col-xl-5 col-lg-6 mb-4">
                                <div class="sticky-top z-3 row gutters-10">
                                    @php
                                        $photos = explode(',', $detailedProduct->photos);
                                    @endphp
                                    <div class="col order-1 order-md-2">
                                        <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'>
                                            @foreach ($detailedProduct->stocks as $key => $stock)
                                                @if ($stock->image != null)
                                                    <div class="carousel-box img-zoom rounded">
                                                        <img
                                                            class="img-fluid lazyload"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            data-src="{{ uploaded_asset($stock->image) }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                        >
                                                    </div>
                                                @endif
                                            @endforeach

                                            @foreach ($photos as $key => $photo)
                                                <div class="carousel-box img-zoom rounded">
                                                    <img
                                                        class="img-fluid lazyload"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($photo) }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-7 col-lg-6">
                                <div class="text-left">
                                    <h1 class="mb-2 fs-20 fw-600 text-main">
                                        {{ $detailedProduct->getTranslation('name') }}
                                    </h1>

                                    @php
                                        $qty = 0;
                                        if($detailedProduct->variant_product){
                                            foreach ($detailedProduct->stocks as $key => $stock) {
                                                $qty += $stock->qty;
                                            }
                                        }
                                        else{
                                            $qty = $detailedProduct->current_stock;
                                        }
                                    @endphp

                                    @if(home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))
                                        <div class="row no-gutters d-flex align-items-baseline py-2">
                                            <del class="h5 fw-600">
                                                {{ home_price($detailedProduct->id) }}
                                                @if($detailedProduct->unit != null)
                                                    <span>/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                @endif
                                            </del>
                                            <div class="">
                                                <strong class="h3 fw-600 text-main">
                                                    {{ home_discounted_price($detailedProduct->id) }}
                                                </strong>
                                                @if($detailedProduct->unit != null)
                                                    <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="row no-gutters mt-3">
                                            <div class="col-sm-2">
                                                <div class="opacity-50 my-2">{{ translate('Price')}}:</div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="">
                                                    <strong class="h2 fw-600 text-primary">
                                                        {{ home_discounted_price($detailedProduct->id) }}
                                                    </strong>
                                                    @if($detailedProduct->unit != null)
                                                        <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <form id="option-choice-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                                    <!-- Quantity + Add to cart -->
                                        <div class="row no-gutters">
                                            <div class="col-sm-10">
                                                <div class="product-quantity d-flex align-items-center">
                                                    <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                                        <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity" disabled="">
                                                            <i class="las la-minus"></i>
                                                        </button>
                                                        <input type="text" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}" max="10" readonly>
                                                        <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                    </div>

                                                    <button type="button"
                                                            class="btn addToCart bg-main mr-2"
                                                            @if(Auth::check())
                                                                onclick="addToCart()"
                                                            @else
                                                                onclick="showCheckoutModal()"
                                                            @endif>
                                                        <i class="las la-cart-plus"></i>
                                                    </button>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="row no-gutters py-3 d-none" id="chosen_price_div">
                                            <div class="col-sm-2">
                                                <div class="opacity-50 my-2">{{ translate('Total Price')}}:</div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="product-price">
                                                    <strong id="chosen_price" class="h4 fw-300 text-primary">

                                                    </strong>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row no-gutters d-none" id="chosen_price_div">
                                            <div class="col d-flex align-items-center fs-20">
                                                <span>{{ translate('Sku') }}:</span>
                                                <div class="product-price fs-18 ml-3">
                                                   {{ $detailedProduct->slug ?? " " }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-gutters d-none" id="chosen_price_div">
                                            <div class="col d-flex align-items-center fs-20">
                                                <span>{{ translate('Category') }}:</span>
                                                <div class="product-price fs-18 ml-3">
                                                    {{ $detailedProduct->category->name ?? "" }}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                <div class="col-xl-9 order-0 order-xl-1 offset-md-3">
                    <div class="bg-white mb-3 shadow-sm rounded">
                        <div class="nav border-main-1 aiz-nav-tabs reviewTab">
                            <a href="#tab_default_1" data-toggle="tab" class="p-3 p-sm-1 text-reset active show">{{ translate('Description')}}</a>
                            <a href="#tab_default_4" data-toggle="tab" class="p-3 p-sm-1 text-reset">{{ translate('Reviews')}}</a>
                            <a href="#tab_default_5" data-toggle="tab" class="p-3 p-sm-1 text-reset">{{ translate('Upload Prescription')}}</a>
                        </div>

                        <div class="tab-content pt-0 border border-top-0">
                            <div class="tab-pane fade active show" id="tab_default_1">
                                <div class="p-4">
                                    @if($detailedProduct->description != null)
                                    <div class="mw-100 overflow-hidden text-left">
                                        <?php echo $detailedProduct->getTranslation('description') ?>
                                    </div>
                                    @else
                                        <div class="text-center fs-18 opacity-70">
                                            {{  translate('There have been no product details for this product yet.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab_default_4">
                                <div class="p-4">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($detailedProduct->reviews as $key => $review)
                                            @if($review->user != null)
                                                <li class="media list-group-item d-flex">
                                                <span class="avatar avatar-md mr-3">
                                                    <img
                                                        class="lazyload"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                        @if($review->user->avatar_original !=null)
                                                        data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                                        @else
                                                        data-src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        @endif
                                                    >
                                                </span>
                                                    <div class="media-body text-left">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="fs-15 fw-600 mb-0">{{ $review->user->name }}</h3>
                                                            <span class="rating rating-sm">
                                                            @for ($i=0; $i < $review->rating; $i++)
                                                                    <i class="las la-star active"></i>
                                                                @endfor
                                                                @for ($i=0; $i < 5-$review->rating; $i++)
                                                                    <i class="las la-star"></i>
                                                                @endfor
                                                        </span>
                                                        </div>
                                                        <div class="opacity-60 mb-2">{{ date('d-m-Y', strtotime($review->created_at)) }}</div>
                                                        <p class="comment-text">
                                                            {{ $review->comment }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    @if(count($detailedProduct->reviews) <= 0)
                                        <div class="text-center fs-18 opacity-70">
                                            {{  translate('There have been no reviews for this product yet.') }}
                                        </div>
                                    @endif

                                    @if(Auth::check())
                                        @php
                                            $commentable = false;
                                        @endphp
                                        @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                            @if($orderDetail->order != null && $orderDetail->order->user_id == Auth::user()->id && $orderDetail->delivery_status == 'delivered' && \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                                @php
                                                    $commentable = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($commentable)
                                            <div class="pt-4">
                                                <div class="border-bottom mb-4">
                                                    <h3 class="fs-17 fw-600">
                                                        {{ translate('Write a review')}}
                                                    </h3>
                                                </div>
                                                <form class="form-default" role="form" action="{{ route('reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="text-uppercase c-gray-light">{{ translate('Your name')}}</label>
                                                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" disabled required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="text-uppercase c-gray-light">{{ translate('Email')}}</label>
                                                                <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="opacity-60">{{ translate('Rating')}}</label>
                                                        <div class="rating rating-input">
                                                            <label>
                                                                <input type="radio" name="rating" value="1">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="2">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="3">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="4">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="5">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="opacity-60">{{ translate('Comment')}}</label>
                                                        <textarea class="form-control" rows="4" name="comment" placeholder="{{ translate('Your review')}}" required></textarea>
                                                    </div>

                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-primary mt-3">
                                                            {{ translate('Submit review')}}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>



                            <div class="tab-pane fade" id="tab_default_5">
                                <div class="p-4">
                                    <form action="{{ route('upload.prescription_image') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <input type="text" style="display: none" name="productId" value="{{ $detailedProduct->id }}">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea name="details_message" id="" cols="30" rows="10" class="form-control" placeholder="What you want to say in www.banglamads.com.bd ???"></textarea>
                                            </div>
                                            <div class="image-upload-container">
                                                    <div class="image-upload-one">
                                                        <div class="center">
                                                            <div class="form-input">
                                                                <label for="file-ip-1">
                                                                    <img id="file-ip-1-preview" src="https://www.chanchao.com.tw/images/default.jpg">
                                                                    <button type="button" class="imgRemove" onclick="myImgRemove(1)"></button>
                                                                </label>
                                                                <input type="file"  name="prescription_image[]" id="file-ip-1" accept="image/*" onchange="showPreview(event, 1);">
                                                            </div>
                                                            <small class="small">Use the &#8634; icon to reset the image</small>
                                                        </div>
                                                    </div>
                                                    <!-- ************************************************************************************************************ -->
                                                    <div class="image-upload-two">
                                                        <div class="center">
                                                            <div class="form-input">
                                                                <label for="file-ip-2">
                                                                    <img id="file-ip-2-preview" src="https://www.chanchao.com.tw/images/default.jpg">
                                                                    <button type="button" class="imgRemove" onclick="myImgRemove(2)"></button>
                                                                </label>
                                                                <input type="file" name="prescription_image[]" id="file-ip-2" accept="image/*" onchange="showPreview(event, 2);">
                                                            </div>
                                                            <small class="small">Use the &#8634; icon to reset the image</small>
                                                        </div>
                                                    </div>
                                                    <!-- ************************************************************************************************************ -->
                                                    <div class="image-upload-three">
                                                        <div class="center">
                                                            <div class="form-input">
                                                                <label for="file-ip-3">
                                                                    <img id="file-ip-3-preview" src="https://www.chanchao.com.tw/images/default.jpg">
                                                                    <button type="button" class="imgRemove" onclick="myImgRemove(3)"></button>
                                                                </label>
                                                                <input type="file" name="prescription_image[]" id="file-ip-3" accept="image/*" onchange="showPreview(event, 3);">
                                                            </div>
                                                            <small class="small">Use the &#8634; icon to reset the image</small>
                                                        </div>
                                                    </div>
                                                    <!-- *********************************************************************************************************** -->
                                                    <div class="image-upload-four">
                                                        <div class="center">
                                                            <div class="form-input">
                                                                <label for="file-ip-4">
                                                                    <img id="file-ip-4-preview" src="https://www.chanchao.com.tw/images/default.jpg">
                                                                    <button type="button" class="imgRemove" onclick="myImgRemove(4)"></button>
                                                                </label>
                                                                <input type="file" name="prescription_image[]" id="file-ip-4" accept="image/*" onchange="showPreview(event, 4);">
                                                            </div>
                                                            <small class="small">Use the &#8634; icon to reset the image</small>
                                                        </div>
                                                    </div>
                                                    <!-- ************************************************************************************************************ -->
                                                    <div class="image-upload-five">
                                                        <div class="center">
                                                            <div class="form-input">
                                                                <label for="file-ip-5">
                                                                    <img id="file-ip-5-preview" src="https://www.chanchao.com.tw/images/default.jpg">
                                                                    <button type="button" class="imgRemove" onclick="myImgRemove(5)"></button>
                                                                </label>
                                                                <input type="file" name="prescription_image[]" id="file-ip-5" accept="image/*" onchange="showPreview(event, 5);">
                                                            </div>
                                                            <small class="small">Use the &#8634; icon to reset the image</small>
                                                        </div>
                                                    </div>
                                                    <!-- ************************************************************************************************************ -->
                                                    <div class="image-upload-six">
                                                        <div class="center">
                                                            <div class="form-input">
                                                                <label for="file-ip-6">
                                                                    <img id="file-ip-6-preview" src="https://www.chanchao.com.tw/images/default.jpg">
                                                                    <button type="button" class="imgRemove" onclick="myImgRemove(6)"></button>
                                                                </label>
                                                                <input type="file" name="prescription_image[]" id="file-ip-6" accept="image/*" onchange="showPreview(event, 6);">
                                                            </div>
                                                            <small class="small">Use the &#8634; icon to reset the image</small>
                                                        </div>
                                                    </div>
                                                    <!-- ************************************************************************************************************** -->
                                                </div>
                                        </div>

                                        @if(Auth::check())
                                            <button type="submit" class="btn bg-main btn-lg text-white fs-24 fw-400 smUploadpresButton">Submit Prescriptions</button>
                                        @else
                                            <button type="reset" class="btn bg-main btn-lg text-white fs-24 fw-400 smUploadpresButton" onclick="showCheckoutModal()"> Submit Prescriptions </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container content_border_top" id="whyChoseUs">
        <div class="row category">
            <div class="col-md-12">
                <div class="title text-center mt-4">
                    <h4>Over The Counter Products</h4>
                </div>
            </div>
        </div>
        <div class="common-hr"></div>
        <div class="row">
            @include('frontend.partials.page_category_section')
        </div>
        <div class="common-hr"></div>
    </div>

@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title" value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login')}}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone')}}" name="email" id="email">
                                @else
                                    <input type="email" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                @endif
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <span class="opacity-60">{{  translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg" placeholder="{{ translate('Password')}}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{  translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}" class="text-reset opacity-60 fs-14">{{ translate('Forgot password?')}}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary btn-block fw-600">{{  translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?')}}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now')}}</a>
                        </div>
                        @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With')}}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="GuestCheckout">
        <div class="modal-dialog modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text"
                                           class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone') }}"
                                           name="email" id="email">
                                @else
                                    <input type="email"
                                           class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           value="{{ old('email') }}" placeholder="{{ translate('Email') }}"
                                           name="email">
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg"
                                       placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}"
                                       class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>

                    </div>
                    <div class="text-center mb-3">
                        <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                        <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                    </div>
                    @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                        <div class="separator mb-3">
                            <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                        </div>
                        <ul class="list-inline social colored text-center mb-3">
                            @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                        <i class="lab la-google"></i>
                                    </a>
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
        });
        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");
            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";
            // }
            // AIZ.plugins.notify('success', 'Copied');
        }
        function show_chat_modal(){
            @if (Auth::check())
            $('#chat_modal').modal('show');
            @else
            $('#login_modal').modal('show');
            @endif
        }

        function showCheckoutModal() {
            $('#GuestCheckout').modal()
        }

    </script>

    <script>
        var number = 1;
        do {
            function showPreview(event, number){
                if(event.target.files.length > 0){
                    let src = URL.createObjectURL(event.target.files[0]);
                    let preview = document.getElementById("file-ip-"+number+"-preview");
                    preview.src = src;
                    preview.style.display = "block";
                }
            }
            function myImgRemove(number) {
                document.getElementById("file-ip-"+number+"-preview").src = "https://www.chanchao.com.tw/images/default.jpg";
                document.getElementById("file-ip-"+number).value = null;
            }
            number++;
        }
        while (number < 5);
    </script>
@endsection