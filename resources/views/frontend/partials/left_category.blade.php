
<div class="bg-white shadow-sm rounded mb-3">
    <div class="fs-15 fw-600 p-3 border-bottom categoryheader">
        {{ translate('Categories') }}
    </div>
    {{-- <div class="p-3">

    </div> --}}
    <ul class="list-unstyled">
        @foreach (\App\Category::where('level', 0)->get() as $category)
            <li class="py-2 categoryList">
                <a class="text-reset fs-18"
                   href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
            </li>
        @endforeach
    </ul>
</div>
