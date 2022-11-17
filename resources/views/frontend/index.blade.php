@extends('frontend.layouts.app')

@section('content')
    <div class="home-banner-area mb-0 mb-lg-4">
        <div class="row">
            <div class="col-lg-12 ml-auto">
                <div class="position-relative">
                    <div class="position-absolute left-7 right-0 d-none d-lg-block" style="z-index: 999;">
                    </div>
                    @if (get_setting('home_slider_images') != null)
                        <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true"
                            data-dots="true" data-autoplay="true" data-infinite="true">
                            @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                            @foreach ($slider_images as $key => $value)
                                <div class="carousel-box">
                                    <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                        <img class="d-block mw-100 img-fit rounded shadow-sm"
                                            src="{{ uploaded_asset($slider_images[$key]) }}"
                                            alt="{{ env('APP_NAME') }} promo" height="277"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <section class="mb-0 mb-lg-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 rounded">
                <div class="d-flex mb-3 align-items-baseline justify-content-center">
                    <h3 class="conte pb-lg-3 pb-0 mb-1 d-inline-block best_selling_title text-main mb-lg-4 sm_title">{{ translate('Featured Products') }}</h3>
                </div>
                <div class="aiz-carousel half-outside-arrow mt-5"
                     data-items="6"
                     data-xl-items="5"
                     data-lg-items="6"
                     data-md-items="3"
                     data-sm-items="3"
                     data-xs-items="3"
                     data-arrows='true'
                     data-infinite='true'
                     data-autoplay="false">
                    @foreach (\App\Models\Medicine::where('fetured_status', 1)->limit(12)->get() as $key => $product)
                        <div class="carousel-box">
                            @include('frontend.partials.single_product_card')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    @if (get_setting('categories_products') != null)
        @php $categories_products = json_decode(get_setting('categories_products')); @endphp
        @foreach ($categories_products as $key => $value)
            @php $category = \App\Category::find($value); @endphp
            <section class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 sm_padding">
                    <div class="card shadow-none border-0 p-0 bg-transparent">
                        <div class="card-body sm_padding">
                            <img class="mr-3 img-fit lazyload" style="max-height: 300px;"
                                 src="{{ static_asset('frontend/images/placeholder.jpg') }}"
                                 data-src="{{ uploaded_asset($category->banner) }}"
                                 alt="{{ translate($category->name) }}">
                            <div class="d-flex align-items-baseline justify-content-between">
                                <h3 class="text-uppercase mt-1 mt-lg-4 text-main sm_title">{{ $category->name}}</h3>
                                <a class="btn btn-primary sm_btn" href="{{ route("category.details", $category->slug) }}">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-2 py-4 px-md-4 py-md-3 rounded">
                <div class="row row-cols-lg-5 row-cols-3 row-flex" id="post_data">
                    @include('frontend.partials.loadmore_product_listing', ['products' =>\App\Models\Medicine::where('category_id', $category->id)->limit(10)->get() ])
                </div>
            </div>
        </div>
    </section>
        @endforeach
    @endif



    {{-- Best Selling --}}
    <div id="section_best_selling">

    </div>


    <section id="upload_prescriptoins">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3">
                <div class="d-flex mb-3 align-items-baseline justify-content-center">
                    <span class="conte pb-1 pb-lg-3 d-inline-block best_selling_title fw-500 text-main mb-4 text-main sm_title">
                        {{ translate('Why Need Upload Prescriptions?') }}</span>
                </div>
                <div class="row prescription-section">
                    <div class="col-md-6 col-12 col-lg-6">
                        <ul class="list-group bg-transparent">
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="fs-24" style="color: #30698e">১. প্রেসক্রিপশন এর ছবি তুলে অথবা স্ক্যান করে আপলোড করুন।</h5>
                            </li>
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="fs-24" style="color: #30698e">২. আমাদের ফার্মাসিস্ট আপনার প্রেসক্রিপশন পেয়ে আপনার দেয়া ফোন নাম্বারে যোগাযোগ করবে। ( সকাল ১০টা
                                    থেকে রাত ১০টা )</h5>
                            </li>
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="fs-24" style="color: #30698e">৩. ফার্মাসিস্ট আপনার সাথে কথা বলে ঔষধ সিলেক্ট করে অর্ডার কনফার্ম করবে।</h5>
                            </li>
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="fs-24" style="color: #30698e">৪. নির্দিষ্ট সময়ে আপনার ঔষধ/পণ্য ডেলিভারী নিন।</h5>
                            </li>
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="fs-24" style="color: #30698e">৫. ঔষধ ডেলিভারীর সময় আপনার প্রেসক্রিপশন প্রদর্শন করুন।</h5>
                            </li>
                        </ul>
                        {{--
                        <button class="btn order-butotn">Upload Prescription</button>
                        --}}
                    </div>

                    <div class="col-md-6 col-12 col-lg-6">
                        <img class="img-fluid sm_doctor_image h-75 float-right" src="{{ static_asset('assets/img/Medicine-bro.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- why chose us --}}

    <div class="" id="whyChoseUs">
        <section class="mb-0 mb-lg-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3">
                    <div class="row category">
                        <div class="col-md-12">
                            <div class="title text-center">
                                <h3 class="text-main sm_title">Why People Love Your Website ?</h3>
                            </div>
                        </div>
                    </div>

                    <div class="common-hr"></div>
                    <div class="row">
                        <div class="col-md-4 p-0">
                            <div class="card c1">
                                <div class="card-body card-bg-image">
                                    <div class="card-content">
                                        <h3>Convenient & Quick</h3>
                                        <p>No waiting in traffic, no haggling, no worries carrying groceries, they're delivered right at
                                            your door.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 p-0">
                            <div class="card c2">
                                <div class="card-body card-bg-image">
                                    <div class="card-content">
                                        <h3>Freshly Picked</h3>
                                        <p>Our fresh produce is sourced every morning, you get the best from us.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 p-0">
                            <div class="card c3">
                                <div class="card-body card-bg-image">
                                    <div class="card-content">
                                        <h3>A wide range of Products</h3>
                                        <p>With 4000+ Products to choose from, forget scouring those aisles for hours.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- why chose us --}}



    {{-- all category section --}}



    <div id="whyChoseUs">
        <section class="mb-0 mb-lg-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3">
                    <div class="row category">
                        <div class="col-md-12">
                            <div class="title text-center mt-4">
                                <h3 class="text-main sm_title">All Available Category In Medihelp ?</h3>
                            </div>
                        </div>
                    </div>
                    <div class="common-hr"></div>
                    <div class="row">
                        @include('frontend.partials.page_category_section')
                    </div>
                    <div class="common-hr"></div>
                </div>
            </div>
        </section>

    </div>

    {{-- all category section --}}





@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.post('{{ route('home.section.best_selling') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
@endsection
