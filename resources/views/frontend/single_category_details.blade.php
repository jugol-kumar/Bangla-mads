@extends('frontend.layouts.app')

@if (isset($category))
    @php
        $meta_title = $category->meta_title;
        $meta_description =$category->meta_description;
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-none border-0 p-0 bg-transparent">
                       <div class="card-body">
                           @if(isset($category))
                               <img class="mr-3 img-fit lazyload" style="max-height: 300px;"
                                    src="{{ static_asset('frontend/images/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($category->banner) }}"
                                    alt="{{ translate($category->name) }}">
                               <h3 class="text-uppercase font-weight-bold mt-4">{{ $category->name}}</h3>
                           @else
                               <h3 class="text-uppercase font-weight-bold mt-4">{{ $slug }}</h3>
                           @endif
                       </div>
                    </div>
                </div>
            </div>
            @if($products->count() > 0)
                <div class="row row-cols-5 row-flex" id="post_data">
                    @include('frontend.partials.loadmore_product_listing')
                </div>
            @else
                <div class="text-center">
                    <img src="{{ static_asset('assets/img/no_data.gif') }}" class="w-75 h-100" alt="">
                </div>
            @endif

            <div class="text-center is_loading" style="display: none">
                <img src="{{ static_asset('assets/img/loading.svg') }}" alt="">
            </div>
        </div>
    </section>

@endsection


@section('script')
    <script type="text/javascript">
        var page = 1;
        var sites = {!! json_encode($products->toArray()) !!};
        $(window).scroll(()=> {
            if (sites.data.length >= 20){
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                    page++;
                    loadMoredata(page);
                }
            }
        });
        function loadMoredata(page){
            $.ajax({
                url: '?page='+page,
                type:"get",
                beforeSend:function(){
                    $('.is_loading').show();
                }
            }).done(function(data) {
                if(data.view == ""){
                    $('.searchOfferId').html('No More Product Found...');
                }
                $('.is_loading').hide();
                $('#post_data').append(data.view);
            }).fail(function (jqXHR, ajaxOptions, thrownError){
                alert("server not response");
            })
        }

    </script>


@endsection
