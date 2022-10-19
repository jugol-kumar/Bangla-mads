
<nav class="navbar" id="sidebar">
    <ul class="navbar-nav list-unstyled components">
        <li class="upload-res">
            <a href="#">
                <i class="la la-upload"></i>
                Upload Prescriptions
            </a>
        </li>
        @if (get_setting('top10_categories') != null)
            @php $categories = json_decode(get_setting('top10_categories')); @endphp
            @foreach ($categories as $key => $value)
                @php $category = \App\Category::find($value); @endphp
                @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id)) > 0)
                    <li class="nav-item">
                        <a href="#{{$category->slug}}"
                           data-toggle="collapse"
                           aria-expanded="false"
                           class="text-black dropdown-toggle nav-link d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img class="mr-3 category-icon lazyload"
                                     src="{{ static_asset('frontend/images/placeholder.jpg') }}"
                                     data-src="{{ uploaded_asset($category->icon) }}"
                                     alt="{{ translate('All Category') }}">
                                <span>{{ $category->name }}</span>
                            </div>

                            <i class="la la-angle-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="{{ $category->slug }}">
                            @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
                                <li class="nav-item">
                                    <i class="las la-caret-right"></i>
                                    <a class="text-black" href="{{ route("category.details",  \App\Category::find($first_level_id)->slug) }}">{{ \App\Category::find($first_level_id)->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route("category.details", $category->slug) }}"
                           class="text-black nav-link d-flex align-items-center">
                            <img class="mr-3 category-icon lazyload"
                                 src="{{ static_asset('frontend/images/placeholder.jpg') }}"
                                 data-src="{{ uploaded_asset($category->icon) }}"
                                 alt="{{ translate('All Category') }}">
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</nav>
