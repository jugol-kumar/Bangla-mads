@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = get_setting('meta_title');
        $meta_description = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')

    <section class="mb-4 pt-3">
        <div class="container sm-px-0">
            <form class="" id="search-form" action="" method="GET">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"
                                 data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left">
                                <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                    <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb"
                                            data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div>
                                {{-- Category --}}
                                @include('frontend.partials.left_category')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
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
                                    @foreach ($nonPagisateProducts as $key => $product)
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
                                            data-id="{{ $nonPagisateProducts->last()->id }}">Load More Product</button>
                                @endif
                            </div>
                        @else
                            <h2 class="d-flex align-items-center justify-content-center h-300px w-100">No Product Found</h2>
                        @endif
                    </div>
                </div>
            </form>
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




{{--@foreach ($nonPagisateProducts as $key => $product)--}}
{{--    <div class="col-md-3 mb-3 product_card_padding">--}}
{{--        <div class="carousel-box single_product_card">--}}
{{--            <div class="aiz-card-box rounded border-radius-5">--}}
{{--                <div class="position-relative">--}}
{{--                    <a href="{{ route('product', $product->slug) }}" class="d-block">--}}
{{--                        <img--}}
{{--                            class="img-fit lazyload mx-auto h-140px h-md-130px px-10px pt-10px"--}}
{{--                            src="{{ static_asset('assets/img/placeholder.jpg') }}"--}}
{{--                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"--}}
{{--                            alt="{{  $product->getTranslation('name')  }}"--}}
{{--                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"--}}
{{--                        >--}}
{{--                    </a>--}}
{{--                    <div class="absolute-top-right aiz-p-hov-icon">--}}
{{--                        <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">--}}
{{--                            <i class="la la-heart-o"></i>--}}
{{--                        </a>--}}
{{--                        <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">--}}
{{--                            <i class="las la-sync"></i>--}}
{{--                        </a>--}}
{{--                        <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">--}}
{{--                            <i class="las la-shopping-cart"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="py-md-3 p-1 py-2 p-md-1 text-center">--}}
{{--                    <h3 class="fw-600 fs-15 text-truncate-2 lh-1-4 mb-0 h-35px">--}}
{{--                        <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  Str::limit($product->getTranslation('name'), 10) }}</a>--}}
{{--                    </h3>--}}

{{--                    <div class="fs-16 mx-5 d-flex align-items-center justify-content-center">--}}
{{--                        <span class="fw-700 text-black">{{ home_discounted_base_price($product->id) }}</span>--}}
{{--                    </div>--}}

{{--                    @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)--}}
{{--                        <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">--}}
{{--                            {{ translate('Club Point') }}:--}}
{{--                            <span class="fw-700 float-right">{{ $product->earn_point }}</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endforeach--}}







@section('script')
    <script type="text/javascript">
        function filter() {
            $('#search-form').submit();
        }

        function rangefilter(arg) {
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>



    <script>
        var _token = $('input[name="csrf-token"]').val();

        $(document).on('click','.searchOfferId',function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var category_id = "{{  $category_id != null ? $category_id : null}}";
            var search_query = "{{  request()->query('q') }}";
            loadMoredata(id, _token , category_id, search_query);
        });

        $('.search_button_list li button').on('click', function (e) {
            e.preventDefault();
            var search_query = $(this).html().toLowerCase();
            let productId = $('.searchOfferId').data('id');
            loadMoredata(productId, _token, null, search_query);
        });


        function loadMoredata(id="", _token, category_id = "null", search_query= ""){
            $.ajax({
                url:"{{ route('loadmore.load_data') }}",
                method:"POST",
                data:{request_product_id:id, category_id: category_id ,q:search_query, _token:"{{ csrf_token() }}"},
                beforeSend:function(){
                    $('#loadMore').html('Loding.........'); //s
                },
                success:function(data)
                {
                    if(data){
                        var lastProductId = $(".searchOfferId").val();
                        console.log('last product id: '+lastProductId);
                        $(".searchOfferId").data('id', lastProductId);
                        $('#loadMore').html('Load more');
                        var len = data.length;
                        $('#post_data').append(data);
                        console.log(data);
                    }else{
                        $('#loadMore').removeClass('bg-main');
                        $('#loadMore').addClass('bg-info');
                        $('#loadMore').attr('disabled',true);
                        $('#loadMore').html('No More Product Found...');
                    }
                }
            });
        }

    </script>


@endsection
