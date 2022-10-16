@foreach(\App\Category::latest()->take(24)->get()->chunk(6) as $value)
    <div class="col-md-3">
        <ul class="list-unstyled">
            @foreach($value as $key => $category)
                <li class="category_single_li">
                    <a class="text-main" href="{{ route('category.details', $category->slug) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endforeach
