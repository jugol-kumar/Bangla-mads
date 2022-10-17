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
    <meta property="og:url" content="{{ route('product', ['slug' => $detailedProduct->slug ?? $detailedProduct->name, 'id' => $detailedProduct->id]) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency" content="{{ \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('css')

@endsection


@section('content')
    <section class="mb-4 pt-3">
        <div class="container sm_padding">
            <div class="bg-transparent rounded p-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mt-4">
                            <div class="col-xl-5 col-lg-6 mb-4">
                                <div class="sticky-top z-3 row gutters-10">
                                    @php
                                        $photos = explode(',', $detailedProduct->photos);
                                    @endphp
                                    <div class="col order-1 order-md-2">
                                        <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'>
                                            @foreach ($photos as $key => $photo)
                                                <div class="carousel-box img-zoom rounded">
                                                    <img
                                                        class="img-fluid lazyload"
                                                        src="{{ uploaded_asset($detailedProduct->photo ?? $detailedProduct?->category?->icon) ?? static_asset('assets/img/placeholder.jpg') }}"
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
                                    <h1 class="mb-0 text-black">
                                        {{ $detailedProduct->name}}
                                    </h1>

                                    <h5 class="text-black-50">{{ $detailedProduct->type }}</h5>

                                    <a class="text-warning" href="{{ route("cname.details", $detailedProduct->c_name) }}">{{ $detailedProduct?->c_name ??  ''}}</a>

                                    <div class="d-flex align-items-baseline mt-3">
                                        <h6 class="mr-2">Generic: </h6>
                                        <a href="{{ route("generic.details", $detailedProduct->generic) }}">{{ $detailedProduct->generic }}</a>

                                    </div>

                                    <div class="d-flex align-items-baseline mb-3">
                                        <h6 class="mr-2">Weight:</h6>
                                        <span class="fs-16"> {{ $detailedProduct->weight }}</span>
                                    </div>

                                    <hr>

                                    <div class="d-flex align-items-baseline mb-5">
                                        <h1 class="fs-18 text-capitalize mr-2">
                                            best Price:
                                        </h1>
                                        <span class="fs-23 font-weight-bold"> {{ $detailedProduct->single_price }}</span>
                                    </div>
                                    <form id="option-choice-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                                    <!-- Quantity + Add to cart -->
                                        <div class="row no-gutters">
                                            <div class="col-sm-10">
                                                <div class="radiobuttons">
                                                    <table class="table table-bordered margin_left_minus_10">
                                                                <tr class="d-flex align-items-center justify-content-between">
                                                                    <td class="border-0">
                                                                        <div class="rdio rdio-primary radio-inline d-flex align-items-baseline">
                                                                            <input name="type" value="single" id="single" type="radio" checked>
                                                                            <label for="single">
                                                                                <strong>Single</strong>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="border-0">
                                                                        {{ $detailedProduct->single_price }}
                                                                    </td>
                                                                    <td class="border-0">
                                                                        <div class="row no-gutters align-items-center mr-3" id="single_sec" style="width: 100px;">
                                                                            <button class="btn col-auto btn-icon btn-sm btn-circle btn-primary decrement"
                                                                                    type="button">
                                                                                <i class="las la-minus"></i>
                                                                            </button>
                                                                            <input type="text" name="quantity"
                                                                                   class="col border-0 text-center flex-grow-1 fs-16 bg-transparent"
                                                                                   placeholder="1" value="1" min="10" max="10" readonly>

                                                                            <button class="btn col-auto btn-icon btn-sm btn-circle btn-success increment"
                                                                                    type="button">
                                                                                <i class="las la-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                {{--  active this module after update packet product price --}}

                                                                @if( $detailedProduct->pack_Price != null)
                                                                    <tr class="d-flex align-items-center justify-content-between">
                                                                        <td class="border-0">
                                                                            <div class="rdio rdio-primary radio-inline d-flex align-items-baseline">
                                                                                <input name="type" value="packet" id="packet" type="radio">
                                                                                <label for="packet">
                                                                                    <strong>Packet</strong>
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="border-0">
                                                                            {{ $detailedProduct->pack_Price }}
                                                                        </td>
                                                                        <td class="border-0">
                                                                            <div class="row no-gutters align-items-center mr-3" id="packet_sec" style="width: 100px;">
                                                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-primary decrement"
                                                                                        disabled
                                                                                        type="button">
                                                                                    <i class="las la-minus"></i>
                                                                                </button>
                                                                                <input type="text" name="quantity"
                                                                                       class="col border-0 text-center flex-grow-1 fs-16 bg-transparent"
                                                                                       placeholder="1" value="1" min="10" max="10" readonly disabled>
                                                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-success increment"
                                                                                        disabled
                                                                                        type="button">
                                                                                    <i class="las la-plus"></i>
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                </div>
                                                <button
                                                    type="button" class="btn btn-primary mr-2 add-to-cart fw-600"
                                                    @if(Auth::check())
                                                    onclick="addToCart()"
                                                    @else
                                                    onclick="showCheckoutModal()"
                                                    @endif
                                                >
                                                    <i class="las la-shopping-bag"></i>
                                                    <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
                                                </button>
                                                <button type="button" class="btn btn-dark buy-now fw-600"
                                                        @if(Auth::check())
                                                        onclick="buyNow()"
                                                        @else
                                                        onclick="showCheckoutModal()"
                                                    @endif
                                                >
                                                    <i class="la la-shopping-cart"></i> {{ translate('Buy Now')}}
                                                </button>

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
                <div class="col-xl-12 order-0 order-xl-1">
                    <div class="bg-white mb-3 shadow-sm rounded">
                        <div class="nav border-main-1 aiz-nav-tabs reviewTab">
                            <a href="#tab_default_1" data-toggle="tab" class="p-3 p-sm-1 text-reset active show">{{ translate('Description')}}</a>
{{--                            <a href="#tab_default_4" data-toggle="tab" class="p-3 p-sm-1 text-reset">{{ translate('Reviews')}}</a>--}}
                            <a href="#tab_default_5" data-toggle="tab" class="p-3 p-sm-1 text-reset">{{ translate('Upload Prescription')}}</a>
                        </div>

                        <div class="tab-content pt-0 border border-top-0">
                            <div class="tab-pane fade active show" id="tab_default_1">
                                <div class="p-4">
                                    @if($detailedProduct->generic != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Generic
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->generic !!}
                                            </p>
                                        </div>
                                    @endif
                                    @if($detailedProduct->indications != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Indications
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->indications !!}
                                            </p>
                                        </div>
                                    @endif

                                    @if($detailedProduct->pharmacology != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Pharmacology
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->pharmacology !!}
                                            </p>
                                        </div>
                                    @endif
                                    @if($detailedProduct->dosage_administration != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Dosage Administration
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->dosage_administration !!}
                                            </p>
                                        </div>
                                    @endif
                                    @if($detailedProduct->contraindications != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Contraindications
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->contraindications !!}
                                            </p>
                                        </div>
                                    @endif

                                      @if($detailedProduct->side_Effects != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Side Effects
                                            </h3>
                                            <p>
                                                {!! $detailedProduct->side_Effects !!}
                                            </p>
                                        </div>
                                     @endif

                                    @if($detailedProduct->pregnancy_and_Lactation != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Pregnancy And Lactation
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->pregnancy_and_Lactation !!}
                                            </p>
                                        </div>
                                    @endif
                                    @if($detailedProduct->therapeutic != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Therapeutic
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->therapeutic !!}
                                            </p>
                                        </div>
                                    @endif

                                    @if($detailedProduct->storage_conditions != null)
                                        <div class="mw-100 overflow-hidden text-left">
                                            <h3 class="details_header">
                                                Storage Conditions
                                            </h3>
                                            <p>
                                                {!! $detailedProduct?->storage_conditions !!}
                                            </p>
                                        </div>
                                    @endif


                                </div>
                            </div>

                            {{--
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
                            --}}


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
                            <textarea class="form-control" rows="8" name="message" required placeholder="{{ translate('Your Question') }}">{{ route('product', ['slug' => $detailedProduct->slug ?? $detailedProduct->name, 'id'=>$detailedProduct->id]) }}</textarea>
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


    <script type="text/javascript">
        $(document).ready(()=>{
            function singleOperation(){
                $("#single_sec .increment").on("click", ()=>{
                    let inputVal = $("#single_sec input").val();
                    $("#single_sec input").attr('value', parseInt(inputVal) + 1);
                })
                $("#single_sec .decrement").on("click", ()=>{
                    let inputVal = $("#single_sec input").val();
                    if (parseInt(inputVal) > 1){
                        $("#single_sec input").attr('value', parseInt(inputVal) - 1);
                    }else{
                        alert("Minimum quantity is 1")
                    }
                })
            }
            function packetOperation(){
                $("#packet_sec .increment").on("click", ()=>{
                    let inputVal = $("#packet_sec input").val();
                    $("#packet_sec input").attr('value', parseInt(inputVal) + 1);
                })
                $("#packet_sec .decrement").on("click", ()=>{
                    let inputVal = $("#packet_sec input").val();
                    if (parseInt(inputVal) > 1){
                        $("#packet_sec input").attr('value', parseInt(inputVal) - 1);
                    }else{
                        alert("Minimum quantity is 1")
                    }
                })
            }

            if($("#single").is(":checked")){
                singleOperation();
            }

            $("#single").on('click', function (){
                $("#packet_sec input").attr('value', 1);

                $('#packet_sec button').attr("disabled", true);
                $('#single_sec button').attr("disabled", false);

                $('#packet_sec input').attr('disabled', 'disabled');
                $('#single_sec input').removeAttr('disabled');

                if($("#single").is(":checked")){
                    singleOperation();
                }
            })


            $("#packet").on('click', function (){
                $("#single_sec input").attr('value', 1);

                $('#packet_sec button').attr("disabled", false);
                $('#single_sec button').attr("disabled", true);
                $('#packet_sec input').removeAttr('disabled');
                $('#single_sec input').attr('disabled', 'disabled');

                if($("#packet").is(":checked")){
                    packetOperation();
                }
            })
        })
    </script>


@endsection
